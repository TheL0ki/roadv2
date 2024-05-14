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
                <a href="/" class="hover:text-blue-400">Home</a>
                <a href="/settings" class="hover:text-blue-400">Settings</a>
                <a href="/batch" class="hover:text-blue-400">Batch Assign</a>
                <a href="/userManagement" class="hover:text-blue-400">User Management</a>
                <a href="/shiftManagement" class="hover:text-blue-400">Shift Management</a>
            </div>

            @auth
                <div class="space-x-6">
                    <a href="/jobs/create">Post a Job</a>

                    <form method="POST" action="/logout">
                        @csrf
                        @method('DELETE')

                        <button>Log Out</button>
                    </form>
                </div>
            @endauth

            @guest()
                <div class="space-x-6">
                    <a href="/register">Sign Up</a>
                    <a href="/login">Log In</a>
                </div>
            @endguest
        </nav>
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
