<x-layout>
    <div class="space-y-4 pt-4">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Name</x-table.head-cell>
                    <x-table.head-cell>Manager</x-table.head-cell>
                    <x-table.head-cell>Members</x-table.head-cell>
                    <x-table.head-cell>Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
            </x-table.body>
        </x-table.table>

        <x-button>Add new Team</x-button>
    </div>
</x-layout>