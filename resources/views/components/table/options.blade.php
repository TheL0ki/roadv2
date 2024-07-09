@props(['modal' => false])

<x-table.body-cell class="text-center">
    <div class="w-full flex justify-around space-x-2">
        <x-button class="bg-green-600 hover:bg-green-900 w-full" onclick="openModal('{{ $modal }}')">Edit</x-button>
        <x-button class="bg-red-600 hover:bg-red-900 w-full">Delete</x-button>
    </div>
</x-table.body-cell>