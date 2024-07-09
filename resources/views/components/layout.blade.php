<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>R.O.A.D</title>
</head>

<body class="bg-neutral-700 text-white pb-20">
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
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button class="space-x-6 flex justify-between items-center">
                        <div>
                            <img src="{{ Vite::asset('storage/app/' . Auth::User()->profilePic) }}" class="w-[40px] h-[40px] rounded-full">
                        </div>
                        <div>
                            {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                        </div>
                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>           
            @endauth

            @guest()
                <div class="space-x-6">
                </div>
                <div class="space-x-6">
                    <x-button><a href="/login">Log In</a></x-button>
                </div>
            @endguest
        </nav>
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
