@extends('frontend.template.master')
@section('main-content')
    <!-- Floating Add Button -->
    <button id="showFormBtn"
        class="fixed bottom-6 right-6 bg-green-600 text-white w-14 h-14 rounded-full shadow-lg 
        flex items-center justify-center text-3xl hover:bg-green-700 transition z-50 cursor-pointer"
        aria-expanded="false" aria-controls="taskFormCard" aria-label="Add task">
        <span class="mb-2">
            &plus;
        </span>
    </button>

    <!-- Backdrop  -->
    <div id="backdrop"
        class="fixed top-20 left-64 right-0 bottom-0 bg-black/10 hidden opacity-0 transition-opacity duration-200 z-40"
        aria-hidden="true"></div>

    <!-- Modal container (positioned inside main area: top-20, left after sidebar 64) -->
    <div id="taskFormCard"
        class="fixed top-20 left-64 right-0 bottom-0 flex items-center justify-center p-4 hidden z-50 pointer-events-none">

        <!-- Panel -->
        <div role="dialog" aria-modal="true" aria-labelledby="taskFormTitle"
            class="w-full max-w-lg bg-white border border-gray-100 rounded-2xl shadow-xl transform transition-all duration-300 translate-y-6 opacity-0 pointer-events-none"
            style="backdrop-filter: blur(4px);">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 id="taskFormTitle" class="text-lg font-semibold text-gray-800">Add New Task</h2>
                    <button id="closeFormBtn" class="text-gray-500 hover:text-gray-700 rounded focus:outline-none"
                        aria-label="Close form">✕</button>
                </div>

                <form id="addTaskForm" method="POST" action="" novalidate>
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

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-gray-700 font-medium text-sm">Status</label>
                            <select name="status" class="w-full mt-1 p-2 border border-gray-200 rounded-md">
                                <option value="0">Not Completed</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium text-sm">Important?</label>
                            <select name="important" class="w-full mt-1 p-2 border border-gray-200 rounded-md">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium text-sm">Due Date</label>
                        <input type="date" name="due_date" class="w-full mt-1 p-2 border border-gray-200 rounded-md">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Add
                            Task</button>
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</button>
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
                    // allow normal submit (or implement AJAX here)
                });
            }
        });
    </script>
@endsection
