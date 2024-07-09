<x-layout>
    <div class="space-y-4 pt-4">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-">Name</x-table.head-cell>
                    <x-table.head-cell>Manager</x-table.head-cell>
                    <x-table.head-cell>Members</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.options />
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.options />
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">TeamName</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamManager</x-table.body-cell>
                    <x-table.body-cell class="text-center">TeamMembers</x-table.body-cell>
                    <x-table.options />
                </x-table.body-row>
            </x-table.body>
        </x-table.table>

        <x-button>Add new Team</x-button>
    </div>
</x-layout>