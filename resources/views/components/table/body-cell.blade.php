@props([
    'loopdate',
    'last' => false,
    'type' => false,
    'color' => false,
    'textColor' => false,
    'ho' => false,
])

@php
    $classes = "";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= ' bg-gray-950';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes .= ' border-solid border-x-2 border-x-yellow-400 ';
        if($last === true) {
            $classes .= ' border-b-2 border-b-yellow-400';
        } else {
            $classes .= ' border-b border-b-white/30';
        }
    } else {
        $classes .= ' border border-white/30';
    }

    if($type === 'schedule') {
        $classes .= ' p-0';
    } else {
        $classes .= ' p-2';
    }
@endphp

@if($type === 'schedule')
    <td {{ $attributes(['class' => $classes]) }} style="background: {{ $color }}; color: {{ $textColor }};">
        @if($ho == 1)
            <div class="border-b-2 border-red-500 text-xs">
        @else
            <div style="font-size: 0.65rem;">
        @endif
            {{ $slot }}
        </div>
    </td>
@else
    <td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>
@endif