<x-layout>
    <div>
        <div class="flex justify-end">
            <x-button onclick="openModal('createUserModal')">+ Add New User</x-button>
        </div>
        <div class="w-100 overflow-x-auto mt-4 p-4 bg-neutral-700 rounded-md">
            <x-table.table>
                <x-table.head>
                    <x-table.head-row>
                        <x-table.head-cell class="w-[200px] md:w-auto text-start">Full Name</x-table.head-cell>
                        <x-table.head-cell class="w-[200px] md:w-auto text-start">Team</x-table.head-cell>
                        <x-table.head-cell class="w-[200px] md:w-auto">Role</x-table.head-cell>
                        <x-table.head-cell class="w-[200px] md:w-auto">Actions</x-table.head-cell>
                    </x-table.head-row>
                </x-table.head>
                <x-table.body>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($user as $item)
                        <x-table.body-row :highlighted="Auth::user()->highlight_current_user_row && $item->id === Auth::id()">
                            <td class="border-t border-white/30">
                                <div class="flex space-x-3 px-3">
                                    <div>
                                        <x-profilePic :path="$item->profilePic" class="w-[50px] h-[50px]" />
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span>{{ $item->firstName . ' ' . $item->lastName }}</span>
                                            <span class="inline-flex items-center rounded-full bg-blue-100 py-1 px-2 text-xs font-medium text-blue-800">
                                                {{ strtoupper($item->model) }}
                                            </span>                                            
                                        </div>
                                        <p class="text-sm text-gray-400">{{ $item->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="border-t border-white/30 px-2">{{ $item->team->displayName }}</td>
                            <td class="text-center border-t border-white/30"><span class="bg-blue-800 rounded-full text-sm font-bold px-3 py-1">{{ ucfirst($item->role->name) }}</span></td>
                            <x-table.options :item=$item category="employee" modal="editUser{{ $i }}"></x-table.options>
                        </x-table.body-row>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </x-table.body>
            </x-table.table>
        </div>
    </div>

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

    <form action="{{ route('employee.save') }}" method="POST">
        @csrf
        @method('POST')
        <x-form.userModal :$teams :$roles :$errors modalName="createUserModal">
            <x-slot:heading>Create New User</x-slot:heading>
        </x-form.userModal>
    </form>

    @php
        $i = 1;
    @endphp
    @foreach ($user as $item)
        <form action="{{ route('employee.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-form.userModal :$teams :$roles modalName="editUser{{ $i }}" :user="$item">
                <x-slot:heading>Edit User {{ $item->firstName }} {{ $item->lastName }}</x-slot:heading>
            </x-form.userModal>
            @php
                $i++;
            @endphp
        </form>
    @endforeach
    
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
                let modals = document.getElementsByClassName('userModal');
                Array.prototype.slice.call(modals).forEach(i => {
                    window.closeModal(i.id);
                })
            }
        };
    </script>
    @if($errors->any())
        <script>
            window.openModal('createUserModal');
        </script>
    @endif
</x-layout>