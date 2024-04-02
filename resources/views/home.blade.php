<x-layout>
    <x-slot:heading>Home</x-slot:heading>
    @foreach ($schedule as $item)
        {{ $item->shift->display }}
    @endforeach
</x-layout>