@props(['item', 'category', 'modal' => false])

<x-table.body-cell class="text-center">
    <div class="w-full flex justify-around space-x-2">
        <div class="w-full">
            <x-button class="bg-green-600 hover:bg-green-900 w-full" onclick="openModal('{{ $modal }}')">Edit</x-button>
        </div>
        <div class="w-full">
            <form action="{{ route($category . '.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-button class="bg-red-600 hover:bg-red-900 w-full">Delete</x-button>
            </form>
        </div>
    </div>
</x-table.body-cell>