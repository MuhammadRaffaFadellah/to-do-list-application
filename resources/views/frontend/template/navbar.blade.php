    <nav class="w-full bg-white shadow px-6 py-5 flex justify-between items-center fixed top-0 z-50">
        <h1 class="text-xl font-bold text-blue-500">To-Do List App</h1>

        <div class="relative">
            <!-- Profile Button -->
            <button id="profileBtn">
                <img src="{{ Asset('images/image.png') }}" alt="" class="w-8 h-8 rounded-full cursor-pointer border border-gray-300">
            </button>

            <!-- Dropdown Menu -->
            <div id="profileMenu" class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md my-2 hidden">
                <a href="" class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">
                    <i class="fa-solid fa-user me-2"></i>
                    <span>Profile</span>
                </a>
                <a href="#logout" class=" block px-4 py-2 hover:bg-gray-100 rounded-b-md">
                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <script>
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        profileBtn.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add('hidden');
            }
        })
    </script>