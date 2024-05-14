<x-layout>
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Full Name</x-table.head-cell>
                    <x-table.head-cell>E-mail</x-table.head-cell>
                    <x-table.head-cell>Team</x-table.head-cell>
                    <x-table.head-cell>Model</x-table.head-cell>
                    <x-table.head-cell>Admin</x-table.head-cell>
                    <x-table.head-cell>Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @foreach ($user as $item)
                    <x-table.body-row>
                        <x-table.body-cell>{{ $item->firstName . ' ' . $item->lastName }}</x-table.body-cell>
                        <x-table.body-cell>{{ $item->email }}</x-table.body-cell>
                        <x-table.body-cell>{{ $item->team->displayName }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $item->model }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">
                            @if ($item->admin == '1')
                                <span>&#9989;</span>
                            @else
                                <span>&#10060;</span>
                            @endif
                        </x-table.body-cell>
                        <x-table.body-cell></x-table.body-cell>
                    </x-table.body-row>
                @endforeach
            </x-table.body>
        </x-table.table>
        <div class="pt-4">
            <x-button>Create New User</x-button>
            <x-button>Create New Team</x-button>
        </div>
</x-layout>