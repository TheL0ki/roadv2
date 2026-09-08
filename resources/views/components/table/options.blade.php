@props(['item', 'category', 'modal' => false])

<td class="text-center border-t border-white/30">
    <div class="w-full flex justify-center gap-2">
        <x-button type="success" buttonType="button" onclick="openModal('{{ $modal }}')">Edit</x-button>
        <form action="{{ route($category . '.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
            @csrf
            @method('DELETE')
            <x-button type="danger">Delete</x-button>
        </form>
    </div>
</td>