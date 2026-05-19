@props(['item', 'category', 'modal' => false])

<td class="text-center border-t border-white/30">
    <div class="w-full flex justify-center space-x-2">
            <span class="text-green-600 hover:underline hover:text-green-900" onclick="openModal('{{ $modal }}')">Edit</span>
            <form action="{{ route($category . '.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <span class="text-red-600 hover:underline hover:text-red-900" type="danger">Delete</span>
            </form>
        </div>
    </div>
</td>