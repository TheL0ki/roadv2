@props(['item'])

<x-table.body-cell class="flex">
    <div>
        <img src="{{ $item->profilePic }}" class="w-[50px] h-[50px] rounded-full">
    </div>
    <div class="px-4 flex items-center">
        <p>{{ $item->firstName . ' ' . $item->lastName }}</p>
    </div>
</x-table.body-cell>