@extends('frontend.template.master')
@section('page-name')
    Dashboard - To-Do List App
@endsection
@section('main-content')
    <!-- Floating Add Button -->
    <button id="showFormBtn"
        class="fixed bottom-0 right-0 bg-green-600 text-white w-14 h-14 rounded-s-sm rounded-t-sm shadow-lg 
        flex items-center justify-center text-3xl hover:bg-green-700 transition z-50 cursor-pointer"
        aria-expanded="false" aria-controls="taskFormCard" aria-label="Add task">
        <span class="mb-2">
            &plus;
        </span>
    </button>

    <!-- Notifcation / Flash message -->
    @if (session('success') || session('error'))
        <div id="notif"
            class="fixed top-20 right-0 z-50 px-5 py-3 rounded-lg shadow-lg text-white 
            {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}">
            {{ session('success') ?? session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const notif = document.getElementById('notif');
                notif.style.opacity = 0;
                notif.style.transition = "opacity .5s ease";
                setTimeout(() => notif.remove(), 500);
            }, 3000);
        </script>
    @endif

    <!-- Card -->
    <div class="bg-white p-6 rounded-lg shadow-md h-full overflow-auto">

        <!-- Search + Filter Dropdown (Modern Minimalist) -->
        <form method="GET" action="" class="mb-5">
            <div class="flex items-center gap-3">

                <!-- SEARCH BAR -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 absolute right-3 top-3"></i>
                    </div>
                </div>

                <!-- FILTER DROPDOWN -->
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-filter text-gray-600"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-cloak x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg p-4 space-y-3 z-50">

                        <!-- FILTER: Status -->
                        <div>
                            <label class="text-xs font-semibold text-gray-600">Status</label>
                            <select name="status_id"
                                class="mt-1 w-full border border-gray-300 text-sm px-2 py-1 rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">All</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ ucfirst($status->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- FILTER: Importance -->
                        <div>
                            <label class="text-xs font-semibold text-gray-600">Importance</label>
                            <select name="is_important"
                                class="mt-1 w-full border border-gray-300 text-sm px-2 py-1 rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">All</option>
                                <option value="2" {{ request('is_important') == 2 ? 'selected' : '' }}>Important ★
                                </option>
                                <option value="1" {{ request('is_important') == 1 ? 'selected' : '' }}>Normal</option>
                            </select>
                        </div>

                        <!-- FILTER: Due Date -->
                        <div>
                            <label class="text-xs font-semibold text-gray-600">Due</label>
                            <select name="due"
                                class="mt-1 w-full border border-gray-300 text-sm px-2 py-1 rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">All</option>
                                <option value="overdue" {{ request('due') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="today" {{ request('due') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="future" {{ request('due') == 'future' ? 'selected' : '' }}>Upcoming</option>
                            </select>
                        </div>

                        <!-- APPLY BUTTON -->
                        <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                            Apply
                        </button>

                    </div>
                </div>
            </div>
        </form>

        <!-- If empty -->
        @if ($tasks->isEmpty())
            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center h-full">
                <i class="fa-regular fa-circle-xmark text-5xl mb-3"></i>
                <p>No tasks found</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($tasks as $task)
                    <div class="relative p-4 my-3 rounded-lg shadow-md hover:shadow-xl transition bg-white pr-12">

                        <!-- Header -->
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $task->title }}
                            </h3>

                            @if ($task->status)
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                @if ($task->status->name == 'expired') bg-red-100 text-red-700
                                @elseif ($task->status->name == 'in progress') bg-blue-100 text-blue-700
                                @elseif ($task->status->name == 'completed') bg-green-100 text-green-700
                                @else bg-gray-100 text-gray-700 @endif">
                                    {{ $task->status->name }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                    No Status
                                </span>
                            @endif
                        </div>

                        <!-- Important -->
                        @if ($task->is_important == 2)
                            <i class="fa-solid fa-star text-yellow-300 text-lg absolute top-4 right-4"></i>
                        @endif

                        <!-- Description -->
                        <p class="text-gray-600 text-sm mt-3">
                            {{ $task->description ?: 'No description' }}
                        </p>

                        <!-- Due date -->
                        <div class="mt-3 flex items-center gap-2">
                            <i class="fa-regular fa-clock text-gray-400"></i>
                            <p class="text-gray-500 text-xs">
                                Due:
                                <span class="font-medium">
                                    {{ $task->due_date ? $task->due_date->format('d M Y - H:i') : 'No due date' }}
                                </span>
                            </p>
                        </div>

                        <!-- Menu -->
                        <div x-data="{ open: false }" class="absolute bottom-3 right-3">
                            <button @click="open = !open" class="px-2 py-1 rounded-lg hover:bg-gray-100 transition">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-500"></i>
                            </button>

                            <div x-cloak x-show="open" @click.outside="open = false"
                                class="absolute right-0 bottom-12 z-50 w-40 bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                                <a href=""
                                    class="flex items-center justify-between px-4 py-2 text-sm hover:bg-gray-50">
                                    Edit <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="" method="POST" onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-between px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Delete <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>


    <!-- Backdrop  -->
    <div id="backdrop"
        class="fixed top-20 left-64 right-0 bottom-0 bg-black/10 hidden opacity-0 transition-opacity duration-200 z-40"
        aria-hidden="true"></div>

    <!-- Modal container -->
    <div id="taskFormCard"
        class="fixed top-20 left-64 right-0 bottom-0 flex items-center justify-center p-4 hidden z-50 pointer-events-none">

        <!-- Panel -->
        <div role="dialog" aria-modal="true" aria-labelledby="taskFormTitle"
            class="w-full max-w-lg bg-white border border-gray-100 rounded-2xl shadow-xl transform transition-all duration-300 translate-y-6 opacity-0 pointer-events-none"
            style="backdrop-filter: blur(4px);">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 id="taskFormTitle" class="text-lg font-semibold text-gray-800">Add New Task</h2>
                    <button id="closeFormBtn"
                        class="text-gray-500 hover:text-gray-700 rounded focus:outline-none cursor-pointer"
                        aria-label="Close form">✕</button>
                </div>

                <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-gray-700 font-medium text-sm">Title</label>
                        <input type="text" name="title" required
                            class="w-full mt-1 p-2 border border-gray-200 rounded-md focus:ring-2 focus:ring-green-200 focus:border-transparent">
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 font-medium text-sm">Description</label>
                        <textarea name="description" rows="3" class="w-full mt-1 p-2 border border-gray-200 rounded-md"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium text-sm">Due Date</label>
                        <input type="datetime-local" name="due_date"
                            class="w-full mt-1 p-2 border border-gray-200 rounded-md">
                    </div>

                    <div class="mb-7">
                        <label class="block text-gray-700 font-medium text-sm">Important?</label>
                        <div class="flex items-center gap-6 mt-3 w-full">
                            @foreach ($importants as $important)
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="is_important" value="{{ $important->id }}"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500"
                                        @if ($loop->first) checked @endif>
                                    <span class="text-gray-700 text-sm">
                                        {{ $important->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="hidden">
                        <label class="block text-gray-700 font-medium text-sm">Status</label>
                        <select name="status_id"
                            class="w-full mt-1 p-2 border border-gray-200 rounded-md bg-gray-100 cursor-not-allowed"
                            disabled>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @if (strtolower($status->name) === 'in progress') selected @endif>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- VALUE ASLI tetap dikirim ke controller -->
                        <input type="hidden" name="status_id"
                            value="{{ $statuses->firstWhere('name', 'In Progress')->id ?? 1 }}">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showBtn = document.getElementById('showFormBtn');
            const backdrop = document.getElementById('backdrop');
            const outer = document.getElementById('taskFormCard');
            if (!showBtn || !backdrop || !outer) return;

            const panel = outer.querySelector('[role="dialog"]');
            const closeBtn = document.getElementById('closeFormBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const form = document.getElementById('addTaskForm');

            if (!panel) return;

            function openCard() {
                document.body.classList.add('overflow-hidden');
                showBtn.setAttribute('aria-expanded', 'true');

                outer.classList.remove('hidden', 'pointer-events-none');
                backdrop.classList.remove('hidden');
                requestAnimationFrame(() => {
                    backdrop.classList.remove('opacity-0');
                    panel.classList.remove('translate-y-6', 'opacity-0', 'pointer-events-none');
                    panel.classList.add('translate-y-0', 'opacity-100');
                });

                const first = panel.querySelector('input[name="title"]');
                if (first) first.focus();
            }

            function closeCard() {
                document.body.classList.remove('overflow-hidden');
                showBtn.setAttribute('aria-expanded', 'false');

                backdrop.classList.add('opacity-0');
                panel.classList.add('translate-y-6', 'opacity-0');

                setTimeout(() => {
                    outer.classList.add('hidden', 'pointer-events-none');
                    backdrop.classList.add('hidden', 'pointer-events-none');
                    panel.classList.remove('translate-y-0', 'opacity-100');
                    panel.classList.add('pointer-events-none');
                }, 240);
            }

            showBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (outer.classList.contains('hidden')) openCard();
                else closeCard();
            });

            if (closeBtn) closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeCard();
            });
            if (cancelBtn) cancelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeCard();
            });

            backdrop.addEventListener('click', function() {
                closeCard();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !outer.classList.contains('hidden')) closeCard();
            });

            panel.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            if (form) {
                form.addEventListener('submit', function(e) {
                    const title = form.querySelector('input[name="title"]');
                    if (!title || !title.value.trim()) {
                        e.preventDefault();
                        title && title.focus();
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
