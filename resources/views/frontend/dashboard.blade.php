@extends('frontend.template.master')
@section('page-name')
    Dashboard - To-Do List App
@endsection
@section('main-content')
    <!-- Floating Add Button -->
    <button id="showFormBtn"
        class="fixed bottom-10 right-10 bg-green-600 text-white w-14 h-14 rounded-full shadow-lg 
        flex items-center justify-center text-3xl hover:bg-green-700 transition z-50 cursor-pointer"
        aria-expanded="false" aria-controls="taskFormCard" aria-label="Add task">
        <span class="mb-2">
            &plus;
        </span>
    </button>

    <!-- Notifcation / Flash message -->
    @if (session('success') || session('error'))
        <div id="notif"
            class="fixed bottom-5 left-5 z-50 px-5 py-3 rounded-lg shadow-lg text-white 
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

    <!-- Card / List for tasks -->
    <div class="bg-white p-6 rounded-lg shadow-md h-full">

        @if ($tasks->isEmpty())
            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center h-full">
                <i class="fa-regular fa-circle-xmark text-5xl mb-3"></i>
                <p>No tasks found</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($tasks as $task)
                    <div
                        class="border p-4 rounded-lg shadow-sm hover:shadow-md transition bg-white flex justify-between items-start">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $task->title }}
                            </h3>

                            <p class="text-gray-600 text-sm mt-1">
                                {{ $task->description ?: 'No description' }}
                            </p>

                            <p class="text-gray-500 text-xs mt-2 flex items-center gap-2">
                                <i class="fa-regular fa-clock"></i>
                                Due:
                                <span class="font-medium">
                                    {{ $task->due_date ? $task->due_date : 'No due date' }}
                                </span>
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <!-- Important -->
                            @if ($task->important)
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded-full">
                                    Important
                                </span>
                            @endif

                            <!-- Status -->
                            @if ($task->status)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full">
                                    {{ $task->status->name }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                    No Status
                                </span>
                            @endif
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

                <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}" novalidate>
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
