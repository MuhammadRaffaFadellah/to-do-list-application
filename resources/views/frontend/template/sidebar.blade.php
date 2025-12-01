<aside class="w-64 bg-white h-[calc(100vh-4rem)] shadow-lg fixed top-16 left-0 p-5 flex flex-col">
    <ul class="space-y-4 text-gray-700">
        <li>
            <a href="/main"
                class="block hover:bg-gray-100 p-2 rounded {{ Request::is('main') ? 'bg-blue-100 text-blue-600 font-semibold' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="#" class="block hover:bg-gray-100 p-2 rounded">All Tasks</a>
        </li>
        <li>
            <a href="#" class="block hover:bg-gray-100 p-2 rounded">Categories</a>
        </li>
        <li>
            <a href="#" class="block hover:bg-gray-100 p-2 rounded">Settings</a>
        </li>
    </ul>
        <a href="#logout" class="block hover:bg-gray-100 p-2 rounded text-gray-700 mt-auto">Logout</a>
</aside>
