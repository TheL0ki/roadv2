<x-layout>
    <div class="space-y-4 pt-4">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Full Name</x-table.head-cell>
                    <x-table.head-cell>E-mail</x-table.head-cell>
                    <x-table.head-cell>Team</x-table.head-cell>
                    <x-table.head-cell>Model</x-table.head-cell>
                    <x-table.head-cell>Role</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Options</x-table.head-cell>
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
                        <x-table.body-cell class="text-center">{{ $item->model }}</x-table.body-cell>
                        <x-table.body-cell class="text-center"><span class="bg-blue-800 rounded-full text-xs font-bold px-3 py-1">{{ ucfirst($item->role->name) }}</span></x-table.body-cell>
                        <x-table.options :item=$item category="user" modal="editUser{{ $i }}"></x-table.options>
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>
    
    <div class="pt-4">
        <x-button onclick="openModal('createUserModal')">Create New User</x-button>
    </div>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <x-form.userModal :$teams :$roles modalName="createUserModal">
            <x-slot:heading>Create New User</x-slot:heading>
        </x-form.userModal>
    </form>

    @php
        $i = 1;
    @endphp
    @foreach ($user as $item)
        <form action="{{ route('user.update', $item->id) }}" method="POST">
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