<x-layout>
    <div class="space-y-4 pt-4">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-1/5">Name</x-table.head-cell>
                    <x-table.head-cell class="w-1/5">Display</x-table.head-cell>
                    <x-table.head-cell class="w-1/5">Colors</x-table.head-cell>
                    <x-table.head-cell class="w-1/5">Hours</x-table.head-cell>
                    <x-table.head-cell class="w-1/5">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">ShiftName</x-table.body-cell>
                    <x-table.body-cell class="text-center">ShiftDisplay</x-table.body-cell>
                    <x-table.body-cell>
                        <div style="background-color: #545e4f; color: #48cb48;">
                            Background: #545e4f <br>
                            Text: #48cb48
                        </div>
                    </x-table.body-cell>
                    <x-table.body-cell class="text-center">8.5</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">ShiftName</x-table.body-cell>
                    <x-table.body-cell class="text-center">ShiftDisplay</x-table.body-cell>
                    <x-table.body-cell>
                        <div style="background-color: #545e4f; color: #48cb48;">
                            Background: #545e4f <br>
                            Text: #48cb48
                        </div>
                    </x-table.body-cell>
                    <x-table.body-cell class="text-center">8.5</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
                <x-table.body-row>
                    <x-table.body-cell class="text-center">ShiftName</x-table.body-cell>
                    <x-table.body-cell class="text-center">ShiftDisplay</x-table.body-cell>
                    <x-table.body-cell>
                        <div style="background-color: #545e4f; color: #48cb48;">
                            Background: #545e4f <br>
                            Text: #48cb48
                        </div>
                    </x-table.body-cell>
                    <x-table.body-cell class="text-center">8.5</x-table.body-cell>
                    <x-table.body-cell class="text-center">
                        <x-button class="bg-green-600 hover:bg-green-900">Edit</x-button>
                        <x-button class="bg-red-600 hover:bg-red-900">Delete</x-button>
                    </x-table.body-cell>
                </x-table.body-row>
            </x-table.body>
        </x-table.table>
    </div>
    <div class="pt-4">
        <x-button>Add Shift</x-button>
    </div>
</x-layout>