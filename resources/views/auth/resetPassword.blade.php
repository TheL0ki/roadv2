<x-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('password.doReset') }}" method="POST">
                @csrf

                <x-form.auth.email value="{{ $_GET['email'] }}"></x-form.x-form.auth.email>

                <x-form.auth.password></x-form.x-form.auth.password>

                <x-form.auth.confirmPassword></x-form.x-form.auth.confirmPassword>

                @if ($errors->any())
                    <x-form.auth.errors>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-form.auth.errors>                   
                @endif

                <div>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <x-form.auth.submitButton>Reset Password</x-form.auth.submitButton>
                </div>
            </form>
        </div>
    </div>
</x-layout>
