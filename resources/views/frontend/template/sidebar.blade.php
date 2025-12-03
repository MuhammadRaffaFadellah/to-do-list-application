<aside class="w-64 bg-white h-full shadow-lg fixed top-16 left-0 p-5 flex flex-col">
    <ul class="space-y-3.5 mt-5 text-gray-700">
        <li>
            <a href="/main"
                class="block hover:bg-blue-100 p-2 rounded {{ Request::is('dashboard') ? 'bg-blue-200 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-list-check me-2.5"></i> My Tasks
            </a>
        </li>
        <li>
            <a href="#" class="block hover:bg-blue-100 p-2 rounded">
                <i class="fa-regular fa-star me-2.5"></i> Important
            </a>
        </li>
        <li>
            <a href="#" class="block hover:bg-blue-100 p-2 rounded">
                <i class="fa-regular fa-clock me-2.5"></i> Due Date
            </a>
        </li>
    </ul>
</aside>
