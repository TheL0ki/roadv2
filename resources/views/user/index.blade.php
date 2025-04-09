<x-layout>
    <div class="w-100 overflow-x-auto">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[200px] md:w-auto">Full Name</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">E-mail</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Team</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Model</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Role</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $i = 1;
                @endphp
                @foreach ($user as $item)
                    <x-table.body-row>
                        <x-table.body-cell>
                            <div class="flex space-x-3">
                                <div>
                                    <x-profilePic :path="$item->profilePic" class="w-[50px] h-[50px]" />
                                </div>
                                <div class="flex items-center">
                                    <p>{{ $item->firstName . ' ' . $item->lastName }}</p>
                                </div>
                            </div>
                        </x-table.body-cell>
                        <x-table.body-cell>{{ $item->email }}</x-table.body-cell>
                        <x-table.body-cell>{{ $item->team->displayName }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ strtoupper($item->model) }}</x-table.body-cell>
                        <x-table.body-cell class="text-center"><span class="bg-blue-800 rounded-full text-xs font-bold px-3 py-1">{{ ucfirst($item->role->name) }}</span></x-table.body-cell>
                        <x-table.options :item=$item category="employee" modal="editUser{{ $i }}"></x-table.options>
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
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
    
    <div class="pt-4">
        <x-button onclick="openModal('createUserModal')">Create New User</x-button>
    </div>

    <form action="{{ route('employee.save') }}" method="POST">
        @csrf
        @method('POST')
        <x-form.userModal :$teams :$roles modalName="createUserModal">
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
</x-layout>