<x-layout>
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Full Name</x-table.head-cell>
                    <x-table.head-cell>E-mail</x-table.head-cell>
                    <x-table.head-cell>Team</x-table.head-cell>
                    <x-table.head-cell>Model</x-table.head-cell>
                    <x-table.head-cell>Role</x-table.head-cell>
                    <x-table.head-cell>Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @foreach ($user as $item)
                    <x-table.body-row>
                        <x-table.body-cell class="flex">
                            <div>
                                <img src="{{ asset($item->profilePic) }}" class="w-[50px] h-[50px] rounded-full">
                            </div>
                            <div class="px-4 flex items-center">
                                <p>{{ $item->firstName . ' ' . $item->lastName }}</p>
                            </div>
                        </x-table.body-cell>
                        <x-table.body-cell>{{ $item->email }}</x-table.body-cell>
                        <x-table.body-cell>{{ $item->team->displayName }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $item->model }}</x-table.body-cell>
                        <x-table.body-cell class="text-center"><span class="bg-blue-800 rounded-full text-xs font-bold px-3 py-1">{{ ucfirst($item->role->name) }}</span></x-table.body-cell>
                        <x-table.body-cell class="text-center">
                            <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                            <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                        </x-table.body-cell>
                    </x-table.body-row>
                @endforeach
            </x-table.body>
        </x-table.table>
        <div class="pt-4">
            <x-button onclick="openModal('createUserModal')">Create New User</x-button>
            <x-button>Create New Team</x-button>
        </div>

        <div id="createUserModal" class="fixed hidden z-50 inset-0 bg-gray-950 bg-opacity-60 overflow-y-auto h-full w-full px-4">
            <div class="relative top-40 mx-auto shadow-xl rounded-md bg-neutral-700 max-w-md">
                <div class="flex justify-end p-2">
                    <button onclick="closeModal('createUserModal')" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
        
                <div class="p-6 pt-0 text-center">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="firstName" class="block text-sm font-medium leading-6">First Name</label>
                                </div>
                                <div class="mt-2">
                                    <input name="firstName" type="text" required
                                        class="block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="lastName" class="block text-sm font-medium leading-6">Last Name</label>
                                </div>
                                <div class="mt-2">
                                    <input name="lastName" type="text" required
                                        class="block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium leading-6">Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required
                                        class="block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="email" class="block text-sm font-medium leading-6">Email</label>
                                </div>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                    class="block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="team" class="block text-sm font-medium leading-6">Team</label>
                                </div>
                                <div class="mt-2">
                                    <select id="team_id" name="team_id" required
                                        class="bg-blend-hard-light block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->displayName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="role" class="block text-sm font-medium leading-6">Role</label>
                                </div>
                                <div class="mt-2">
                                    <div class="grid">
                                        <select id="role_id" name="role_id" required
                                            class="bg-blend-hard-light appearance-none row-start-1 col-start-1 bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-center justify-between">
                                    <label for="model" class="block text-sm font-medium leading-6">Model</label>
                                </div>
                                <div class="mt-2">
                                    <select id="model" name="model" required
                                    class="bg-blend-hard-light block w-full bg-neutral-500 rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                        <option value="ft">Full Time</option>
                                        <option value="pt">Part Time</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <x-button class="bg-green-600 hover:bg-green-900">Save</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900" onclick="closeModal('createUserModal')">Cancel</x-button>
                    </form>
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
                    let modals = document.getElementsById('createUserModal');
                    Array.prototype.slice.call(modals).forEach(i => {
                        i.style.display = 'none'
                    })
                }
            };
        </script>
</x-layout>