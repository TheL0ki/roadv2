@props(['loopdate', 'last' => false])

@php
    $classes = "py-2 px-2 border border-white/30";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= ' bg-gray-950';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes .= ' bg-blue-800';
    }
@endphp

<td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>