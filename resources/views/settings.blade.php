<x-layout>
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="space-y-4 pt-4">
            <div class="flex justify-center overflow-x-auto">
                <div class="w-2/5 flex flex-col space-y-4">
                    <div class="flex items-center">
                        <label for="firstName" class="w-1/4">First Name</label>
                        <input type="text" id="firstName" name="firstName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->firstName }}" disabled/>
                    </div>
                    <div class="flex items-center">
                        <label for="lastName" class="w-1/4">Last Name</label>
                        <input type="text" id="lastName" name="lastName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->lastName }}" disabled/>
                    </div>
                    <div class="flex items-center">
                        <label for="email" class="w-1/4">E-Mail Address</label>
                        <input type="text" id="email" name="email" class="w-full bg-white/10" value="{{ Auth::User()->email }}" autocomplete="email" />
                    </div>
                    <div class="flex items-center">
                        <div class="w-1/4"><label for="avatar">Profile picture</label></div>
                        <div class="flex justify-around w-full items-center">
                            <x-profilePic :path="Auth::user()->profilePic" class="w-[50px] h-[50px]" />
                            <input id="avatar" type="file" id="profilePic"name="profilePic" accept=".png, .jpg, .jpeg, .gif">
                            @error('profilePic')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <input type="hidden" name="userId" value="{{ Auth::User()->id }}">
                        <x-button role="submit" class="bg-green-600 hover:bg-green-900">Save</x-button>
                        <x-button id="changePWDbtn">Change Password</x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <x-modal.success>
        {{ session('success') }}
    </x-modal.success>

    @if (session('success'))
        <script>
            document.getElementById("successModal").classList.remove('hidden');

            setTimeout(() => {
                document.getElementById("successModal").classList.add('hidden');
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