<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>R.O.A.D</title>
</head>

<body class="bg-black/80 text-white pb-20">
    <div class="px-10">
        <nav class="flex justify-between items-center py-2 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}"  class="max-w-32">
                </a>
            </div>
            @auth
                <div class="space-x-6">
                    <x-nav-link href="/">Home</x-nav-link>
                    <x-nav-link href="/settings">Settings</x-nav-link>
                    @admin
                        <x-nav-link href="/batch">Batch Assign</x-nav-link>
                        <x-nav-link href="/userManagement">User Management</x-nav-link>
                        <x-nav-link href="/teamManagement">Team Management</x-nav-link>
                        <x-nav-link href="/shiftManagement">Shift Management</x-nav-link>
                    @endadmin
                </div>
                <div class="space-x-6 flex justify-between items-center">
                    <div>
                        {{ auth()->user()->email }}
                    </div>
                    <div>
                        <img src="{{ auth()->user()->profilePic }}" class="w-[50px] h-[50px] rounded-full">
                    </div>
                    <div">
                        <form method="POST" action="/logout">
                            @csrf
                            @method('DELETE')
    
                            <x-button>Log Out</x-button>
                        </form>
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
        <main class="px-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
