<x-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <x-form.auth.email></x-form.auth.email>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6">Password</label>
                        <div class="text-sm">
                            <a href="{{  route('password.request') }}" class="font-semibold text-blue-400 hover:text-blue-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full bg-white/10 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-start space-x-2">
                        <div class="text-sm">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-400 focus:ring-blue-400">
                        </div>
                        <label for="remember" class="block text-sm font-medium leading-6">Remember me</label>
                    </div>
                </div>

                <div>
                    <x-form.auth.submitButton>Sign In</x-form.auth.submitButton>
                </div>
            </form>
        </div>
    </div>
</x-layout>
