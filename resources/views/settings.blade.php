<x-layout>
    <div class="relative">
        <form action="/settings" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="space-y-4 pt-4 w-full">
                <div class="flex justify-center">
                    <div class="w-2/5 flex flex-col space-y-4">
                        <div class="flex items-center">
                            <label for="firstName" class="w-1/4">First Name</label>
                            <input type="text" name="firstName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->firstName }}" disabled/>
                        </div>
                        <div class="flex items-center">
                            <label for="lastName" class="w-1/4">Last Name</label>
                            <input type="text" name="lastName" class="w-full cursor-not-allowed bg-white/10" value="{{ Auth::User()->lastName }}" disabled/>
                        </div>
                        <div class="flex items-center">
                            <label for="email" class="w-1/4">E-Mail Address</label>
                            <input type="text" name="email" class="w-full bg-white/10" value="{{ Auth::User()->email }}" />
                        </div>
                        <div class="flex items-center">
                            <div class="w-1/4"><label for="email">Profile picture</label></div>
                            <div class="flex justify-around w-full items-center">
                                <img src="{{ Vite::asset('storage/app/' . Auth::User()->profilePic) }}" class="w-[50px] rounded-full">
                                <input type="file" id="profilePic"name="profilePic" accept=".png, .jpg, .jpeg, .gif">
                                @error('profilePic')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <x-button role="submit" class="bg-green-600 hover:bg-green-900">Save</x-button>
                            <x-button id="changePWD">Change Password</x-button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="userId" value="{{ Auth::User()->id }}">
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
        
    </div>
    <script>
        document.getElementById("changePWD").addEventListener("click", function(event){
            event.preventDefault();
            openModal('changePWD');
        });
    </script>
</x-layout>