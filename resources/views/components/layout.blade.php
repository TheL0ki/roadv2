<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>R.O.A.D</title>
</head>

<body class="bg-neutral-600 text-white pb-20">
    <div>
        <nav class="flex justify-between items-center py-2 border-b border-white/10 bg-neutral-700 px-2 md:px-10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}"  class="max-w-32">
                </a>
            </div>
            @auth
                <div class="space-x-6 hidden md:block">
                    @admin
                        <x-nav-link href="/batch">Batch Assign</x-nav-link>
                        <x-nav-link href="/userManagement">User Management</x-nav-link>
                        <x-nav-link href="/teamManagement">Team Management</x-nav-link>
                        <x-nav-link href="/shiftManagement">Shift Management</x-nav-link>
                    @endadmin
                </div>
                <div class="relative hidden md:block">
                    <button class="pt-2 pr-2 pl-2 space-x-6 flex justify-between items-center" id="dropdown-button">
                        <div>
                            <x-profilePic :path="Auth::User()->profilePic" class="w-[40px] h-[40px]" />
                        </div>
                        <div>
                            {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                        </div>
                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div id="dropdown-menu" 
                        class="pt-2 left-0 w-full absolute bg-neutral-700 shadow-md 
                               transition-transform duration-300 ease-in-out transform scale-y-0 origin-top 
                               opacity-0 pointer-events-none">
                        <!-- Dropdown items -->
                        <a href="/settings" class="block py-2 px-4 text-white hover:bg-neutral-600">Settings</a>
                        <a href="/logout" class="block py-2 px-4 text-white hover:bg-neutral-600">Logout</a>
                    </div>
                </div>
            @endauth

            @guest()
                <div class="space-x-6">
                </div>
                <div class="space-x-6">
                    <x-button><a href="/login">Log In</a></x-button>
                </div>
            @endguest
        </nav>
        <main class="px-2 md:px-10 pt-2">
            {{ $slot }}
        </main>
    </div>
    <script type="text/javascript">
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');

        // Function to open dropdown
        function openDropdown() {
            dropdownMenu.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                dropdownMenu.classList.remove('scale-y-0');
            }, 10);
        }

        // Function to close dropdown
        function closeDropdown() {
            dropdownMenu.classList.add('scale-y-0');
            setTimeout(() => {
                dropdownMenu.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        // Toggle dropdown on button click
        dropdownButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from propagating to document

            if (dropdownMenu.classList.contains('scale-y-0')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
                closeDropdown();
            }
        });

    </script>
</body>

</html>
