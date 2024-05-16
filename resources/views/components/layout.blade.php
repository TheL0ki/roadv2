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
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}"  class="max-w-32">
                </a>
            </div>
            <div class="space-x-6">
                <x-nav-link href="/">Home</x-nav-link>
                <x-nav-link href="/settings">Settings</x-nav-link>
                <x-nav-link href="/batch">Batch Assign</x-nav-link>
                <x-nav-link href="/userManagement">User Management</x-nav-link>
                <x-nav-link href="/teamManagement">Team Management</x-nav-link>
                <x-nav-link href="/shiftManagement">Shift Management</x-nav-link>
            </div>
            
            @auth
                <div class="space-x-6">
                    <form method="POST" action="/logout">
                        @csrf
                        @method('DELETE')

                        <x-button>Log Out</x-button>
                    </form>
                </div>
            @endauth

            @guest()
                <div class="space-x-6">
                </div>
            @endguest
        </nav>
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
