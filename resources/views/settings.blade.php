<x-layout>
    <form>
        @method('PATCH')
        @csrf
        <div class="space-y-4 pt-4 w-full">
            <div class="flex justify-center">
                <div class="w-2/5 flex flex-col space-y-4">
                    <div class="flex items-center">
                        <label for="firstName" class="w-1/4">First Name</label>
                        <input type="text" name="firstName" class="w-full cursor-not-allowed bg-white/10" value="FirstName" disabled/>
                    </div>
                    <div class="flex items-center">
                        <label for="lastName" class="w-1/4">Last Name</label>
                        <input type="text" name="lastName" class="w-full cursor-not-allowed bg-white/10" value="LastName" disabled/>
                    </div>
                    <div class="flex items-center">
                        <label for="email" class="w-1/4"> E-Mail Address</label>
                        <input type="text" name="email" class="w-full bg-white/10" value="E-Mail-Address" />
                    </div>
                    <div class="flex justify-between">
                        <x-button role="submit">Save</x-button>
                        <x-button>Change Password</x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>