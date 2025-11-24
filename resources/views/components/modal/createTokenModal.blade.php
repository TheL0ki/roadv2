<div id="createTokenModal" class="fixed hidden inset-0 bg-gray-950 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 h-screen w-screen px-4">
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-neutral-700 max-w-lg">
        <div class="flex justify-between p-2 border-b border-white/20">
            <div>
                <h2 class="text-2xl font-bold text-left">{{ $heading }}</h2>
            </div>
            <div>
                <button onclick="closeModal('createTokenModal')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <form action="/apiAccess" method="POST">
            @csrf
            @method('POST')
            <div class="p-4 mb-2">
                <div class="flex items-center justify-between">
                    <label class="" for="tokenName">Token Name:</label>
                </div>
                <div class="mt-2">
                    <x-form.textInput id="tokenName" name="tokenName" type="text" required></x-form.textInput>
                </div>
                <div class="flex justify-end mt-2">
                    <x-button class="bg-green-600 hover:bg-green-900" type="submit">Create New Token</x-button>
                </div>
            </div>
            @error('tokenName')
                <div class="bg-red-300 text-red-600 border border-red-600 rounded p-2 w-64 mt-2 text-center">
                    {{ $message }}
                </div>
            @enderror
        </form>
    </div>
</div>