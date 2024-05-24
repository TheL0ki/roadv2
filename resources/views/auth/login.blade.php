<x-layout>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
     @endif

    <form method="POST" action="/login">
        @csrf
        <div class="space-y-2">
            <div class="space-x-2">
                <label for="email">E-Mail</label>
                <input class="rounded-xl bg-white/10 border border-white/10 px-5 py-4" label="E-Mail" name="email" type="email" />
            </div>
            <div class="space-x-2">
                <label for="password">Password</label>
                <input class="rounded-xl bg-white/10 border border-white/10 px-5 py-4" label="Password" name="password" type="password" />
            </div>
        </div>
        <x-button>Login</x-button>
    </form>
</x-layout>
