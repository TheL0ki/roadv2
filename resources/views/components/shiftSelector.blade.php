@props(['shifts', 'user', 'loopdate', 'i'])
@php
    if ($loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $last = true;
    } else {
        $last = false;
    }
@endphp

<x-table.body-cell class="text-center w-[100px]" :$loopdate :$last>
    <div class="h-full w-full">
        <x-form.select name="shift[{{ $i }}][shift]">
            @php
                $todayShift = $user->schedule->where('day', $loopdate->format('d'))->where('month', $loopdate->format('m'))->where('year', $loopdate->format('Y'))->first();
            @endphp
            @if ($todayShift)
                <option value="{{ $todayShift->shift->id }}">{{ $todayShift->shift->name }}</option>
            @endif
            <option value="null">--</option>
            @foreach ($shifts as $shift)
                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
            @endforeach
        </x-form.select>
    </div>
    <div class="h-full w-full">
        @if ($todayShift && $todayShift->shift->hoAllowed === 1)
            Office: <input type="checkbox" name="shift[{{ $i }}][homeOffice]" value="1" @if($todayShift->homeOffice == 1) checked @endif>
        @else
            &nbsp;
        @endif
    </div>
</x-table.body-cell>