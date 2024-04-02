<x-layout>
    <x-slot:heading>Home</x-slot:heading>
    @foreach ($schedule as $item)
        {{ $item->shift->display }}
    @endforeach
    <div>
        {{ $schedule->links() }}
    </div>
</x-layout>