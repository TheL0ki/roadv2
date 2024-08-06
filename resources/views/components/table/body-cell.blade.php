@props([
    'loopdate',
    'last' => false,
    'type' => false,
    'color' => false,
    'textColor' => false,
    'ho' => false,
])

@php
    $classes = "p-2";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= ' bg-gray-950';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes .= ' border-solid border-x-2 border-x-blue-700 ';
        if($last === true) {
            $classes .= ' border-b-2 border-b-blue-700';
        } else {
            $classes .= ' border-b border-b-white/30';
        }
    } else {
        $classes .= ' border border-white/30';
    }
@endphp

@if($type === 'schedule')
    <td {{ $attributes(['class' => $classes]) }} style="background: {{ $color }}; color: {{ $textColor }};">
        @if($ho == 1)
            <div class="border-b-2 border-red-500 text-xs">
        @else
            <div class="text-xs">
        @endif
            {{ $slot }}
        </div>
    </td>
@else
    <td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>
@endif