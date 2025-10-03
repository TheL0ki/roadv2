@props(['item', 'category', 'modal' => false])

<x-table.body-cell class="text-center">
    <div class="w-full flex justify-around space-x-2">
        <div class="w-full">
            <x-button class="w-full" type="success" onclick="openModal('{{ $modal }}')">Edit</x-button>
        </div>
        <div class="w-full">
            <form action="{{ route($category . '.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-button class="w-full" type="danger">Delete</x-button>
            </form>
        </div>
    </div>
</x-table.body-cell>