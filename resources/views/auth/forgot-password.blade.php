<x-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/forgot-password" method="POST">
                @csrf
                <x-form.auth.email></x-form.auth.email>
                @if ($errors->any())
                    <x-form.auth.errors>{{ $errors->first() }}</x-form.auth.errors>
                @endif
                <div>
                    <x-form.auth.submitButton>Request Password</x-form.auth.submitButton>
                </div>
            </form>
        </div>
    </div>
</x-layout>
