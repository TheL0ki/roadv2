@props(['shifts', 'user', 'loopdate', 'i'])
@php
    if ($loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $last = true;
    } else {
        $last = false;
    }
@endphp

<x-table.body-cell class="text-center w-[100px] px-0 py-0" :$loopdate :$last>
    <div class="flex flex-col h-full w-full p-1">
        <div class="h-[50px] content-center">
            @php
                $todayShift = $user->schedule->where('day', $loopdate->format('d'))->where('month', $loopdate->format('m'))->where('year', $loopdate->format('Y'))->first();
            @endphp
            @if(in_array(Auth::user()->role->id, [1, 2]))
                <x-form.select name="shift[{{ $i }}][shift]">
                    @if ($todayShift)
                        <option value="{{ $todayShift->shift->id }}">{{ $todayShift->shift->name }}</option>
                    @endif
                    <option value="null">--</option>
                    @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                </x-form.select>
            @else
                @if ($todayShift)
                    <div class="border border-white/30">{{ $todayShift->shift->name }}</div>
                    <input type="hidden" name="shift[{{ $i }}][shift]" value="{{ $todayShift->shift->id }}">
                @else
                    <div>&nbsp;</div>
                @endif
            @endif
        </div>
        <div class="h-[50px] content-center">
            @if ($todayShift && $todayShift->shift->flexLoc === 1)
                HO: <input type="checkbox" name="shift[{{ $i }}][flexLoc]" value="1" @if($todayShift->flexLoc == 1) checked @endif>
            @endif
        </div>
    </div>
</x-table.body-cell>