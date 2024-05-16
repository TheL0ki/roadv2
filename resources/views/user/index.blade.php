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
                                <img src="{{ $item->profilePic }}" class="w-[50px] h-[50px] rounded-full">
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
            <x-button>Create New User</x-button>
            <x-button>Create New Team</x-button>
        </div>
</x-layout>