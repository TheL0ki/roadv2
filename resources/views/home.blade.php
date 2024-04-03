<x-layout>
    <x-slot:heading>Home</x-slot:heading>
    <?php // dd($user); ?>
    @foreach ($user as $item)
        {{ $item->firstName }} {{ $item->lastName }} @foreach ($item->schedule as $schedule) {{ $schedule->shift->id}} [{{ $schedule->shift->display }}] @endforeach<br>
    @endforeach
</x-layout>