<x-layout>
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="flex justify-center">
        @method('PATCH')
        @csrf
        <div class="max-w-2xl grow space-y-2">
            <div>
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->firstName }}" disabled/>
            </div>
            <div>
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->lastName }}" disabled/>
            </div>
            <div>
                <label for="email">E-Mail Address</label>
                <input type="text" id="email" name="email" class="w-full bg-white/10" value="{{ Auth::User()->email }}" autocomplete="email" />
            </div>
            <div>
                <label for="avatar">Profile picture</label>
                <div class="flex justify-around w-full items-center">
                    <x-profilePic :path="Auth::user()->profilePic" class="w-[50px] h-[50px]" />
                    <input id="avatar" type="file" id="profilePic"name="profilePic" accept=".png, .jpg, .jpeg, .gif">
                    @error('profilePic')
                        {{ $message }}
                    @enderror
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