@props(['user', 'loopdate', 'i'])
@php
    if ($loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $last = true;
    } else {
        $last = false;
    }
@endphp

<x-table.body-cell class="text-center w-[100px]" :$loopdate :$last>
    <x-form.select name="shift[{{ $i }}][shift]">
        @php
            $todayShift = $user->schedule->where('day', $loopdate->format('d'))->where('month', $loopdate->format('m'))->where('year', $loopdate->format('Y'))->first();
        @endphp
        @if ($todayShift)
            <option value="{{ $todayShift->shift->id }}">{{ $todayShift->shift->display }}</option>
        @endif
        <option value="null">--</option>
        @foreach ($user->team->shift as $shift)
            <option value="{{ $shift->id }}">{{ $shift->display }}</option>
        @endforeach
    </x-form.select>
    @if ($todayShift && $todayShift->shift->hoAllowed === 1)
        HO: <input type="checkbox" name="shift[{{ $i }}][homeOffice]" value="1">
    @endif
</x-table.body-cell>