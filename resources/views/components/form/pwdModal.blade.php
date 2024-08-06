@props(['modalName'])

<div id="{{ $modalName }}" class="fixed hidden inset-0 bg-gray-950 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 h-screen w-screen px-4">
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-neutral-700 max-w-md">
        <div class="flex justify-between p-2 border-b border-white/20">
            <div>
                <h2 class="text-2xl font-bold text-left">{{ $heading }}</h2>
            </div>
            <div>
                <button onclick="closeModal('{{ $modalName }}')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-8 pt-2">
            <div class="mb-4">
                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6">Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" class="w-full bg-white/10" required />
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm font-medium leading-6">Confirm</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-white/10" required />
                    </div>
                </div>
                
                <div class="mb-2">
                    @error('password')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <input type="hidden" name="userId" value="{{ Auth::User()->id }}">
            <div class="flex justify-between pt-2">
                <x-button class="bg-green-600 hover:bg-green-900">Save</x-button>
                <x-button class="bg-red-600 hover:bg-red-900" onclick="closeModal('{{ $modalName }}')">Cancel</x-button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">            
    window.openModal = function(modalId) {
        document.getElementById(modalId).style.display = 'block'
        document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
    };

    window.closeModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none'
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    };

    // Close all modals when press ESC
    document.onkeydown = function(event) {
        event = event || window.event;
        if (event.keyCode === 27) {
            document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
            let modals = document.getElementsById('{{ $modalName }}');
            Array.prototype.slice.call(modals).forEach(i => {
                i.style.display = 'none'
            })
        }
    };
</script>