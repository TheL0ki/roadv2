@props(['loopdate'])

@php
    $classes = "py-2 px-2";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= '  bg-gray-950';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes .= ' border-double border-x-2 border-x-blue-700 border-t-2 border-t-blue-700 border-b border-b-white/30';
    }
@endphp

<th {{ $attributes(['class' => $classes])}}>{{ $slot }}</th>