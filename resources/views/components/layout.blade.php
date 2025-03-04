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
        <nav class="flex justify-between items-center bg-neutral-700 py-2 px-2 md:px-10">
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
                
                <div class="grid md:hidden content-center">
                    <button id="mobileMenuButton">
                        <svg fill="rgb(203, 203, 203)" height="32px" id="Layer_1" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z"/>
                        </svg>
                    </button>
                </div>

                <div class="relative hidden md:block">
                    <button class="space-x-6 flex justify-between items-center" id="dropdown-button">
                        <div>
                            <x-profilePic :path="Auth::User()->profilePic" class="size-[40px]" />
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
        <div id="mobileMenuContainer" class="left-0 w-full absolute bg-neutral-700 shadow-md 
        transition-transform duration-300 ease-in-out transform scale-y-0 origin-top 
        opacity-0 pointer-events-none md:hidden">
            <!-- Dropdown items -->
            @admin
                <a href="/batch" class="block py-2 px-4 text-white hover:bg-neutral-600">Batch Assign</a>
                <a href="/userManagement" class="block py-2 px-4 text-white hover:bg-neutral-600">User Management</a>
                <a href="/teamManagement" class="block py-2 px-4 text-white hover:bg-neutral-600">Team Management</a>
                <a href="/shiftManagement" class="block py-2 px-4 text-white hover:bg-neutral-600">Shift Management</a>
                <hr>
            @endadmin
            <a href="/settings" class="block py-2 px-4 text-white hover:bg-neutral-600">Settings</a>
            <a href="/logout" class="block py-2 px-4 text-white hover:bg-neutral-600">Logout</a>
        </div>
        <main class="px-2 md:px-10 pt-2">
            {{ $slot }}
        </main>
    </div>
    <script src="{{ Vite::asset('resources/js/dropdownMenu.js')}}" type="text/javascript"></script>
    <script src="{{ Vite::asset('resources/js/mobileMenu.js')}}" type="text/javascript"></script>
</body>

</html>
