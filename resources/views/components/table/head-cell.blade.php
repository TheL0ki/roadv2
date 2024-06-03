@props(['loopdate'])

@php
    $classes = "py-2";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= '  bg-gray-950';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes .= ' border-l border-r border-t border-blue-500';
    }
@endphp

<th {{ $attributes(['class' => $classes])}}>{{ $slot }}</th>