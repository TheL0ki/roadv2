<x-layout>
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="flex justify-center">
        @method('PATCH')
        @csrf
        <div class="w-100 max-w-2xl grow space-y-2 overflow-x-auto mt-4 p-4 bg-neutral-700 rounded-md">
            <div>
                <label for="firstName" class="text-sm">First Name</label>
                <input type="text" id="firstName" name="firstName" class="mt-1 w-full cursor-not-allowed bg-white/10 rounded-md" value="{{ Auth::User()->firstName }}" disabled/>
            </div>
            <div>
                <label for="lastName" class="text-sm">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="mt-1 w-full cursor-not-allowed bg-white/10 rounded-md" value="{{ Auth::User()->lastName }}" disabled/>
            </div>
            <div>
                <label for="email" class="text-sm">E-Mail Address</label>
                <input type="text" id="email" name="email" class="mt-1 w-full bg-white/10 rounded-md" value="{{ Auth::User()->email }}" autocomplete="email" />
            </div>
            <div>
                <label for="profilePic" class="text-sm">Profile picture</label>
                <div class="mt-1 flex justify-around w-full items-center">
                    <x-profilePic :path="Auth::user()->profilePic" class="w-[50px] h-[50px]" />
                    <input type="file" id="profilePic" name="profilePic" accept=".png, .jpg, .jpeg, .gif" class="bg-white/10 rounded-md">
                    @error('profilePic')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="border-t border-white/20 pt-4 mt-4">
                <h3 class="text-sm font-medium text-neutral-300 mb-3">Preferences</h3>
                <div class="flex items-center gap-2">
                <input type="checkbox" id="highlightCurrentUserRow" name="highlightCurrentUserRow" value="1" class="rounded bg-white/10 border-neutral-500 size-4"
                    @checked(Auth::user()->highlight_current_user_row ?? true) />
                <label for="highlightCurrentUserRow">Highlight my row in tables</label>
            </div>
            </div>
            <div class="flex justify-around space-x-4">
                <x-button role="submit" class="bg-green-600 hover:bg-green-900 w-full">Save</x-button>
                <x-button id="changePWDbtn" class=" w-full">Change Password</x-button>
            </div>
        </div>
        <input type="hidden" name="userId" value="{{ Auth::User()->id }}">
    </form>

    <x-modal.feedback>
        {{ session('feedback') }}
    </x-modal.feedback>

    @if (session('feedback'))
        <script>
            document.getElementById("feedbackModal").classList.remove('hidden');

            setTimeout(() => {
                document.getElementById("feedbackModal").classList.add('hidden');
            }, 2000);
        </script>
    @endif
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <x-form.pwdModal modalName="changePWD">
            <x-slot:heading>Change Password</x-slot:heading>
        </x-form.pwdModal>
    </form>
    <script>
        document.getElementById("changePWDbtn").addEventListener("click", function(event){
            event.preventDefault();
            openModal('changePWD');
        });
    </script>
    @error('password')
        <script>
            window.onload = function() {
                openModal('changePWD');
            }
        </script>
    @enderror
</x-layout>