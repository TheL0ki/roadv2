@props(['loopdate', 'last' => false])

@php
    $classes = "border-white/20 py-2 px-2";

    if (isset($loopdate) && ($loopdate->format('N') === '6' || $loopdate->format('N') === '7')) {
        $classes .= ' bg-black';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
        $classes = 'py-2 px-2 border-l border-r border-blue-500';
    }

    if (isset($loopdate) && $loopdate->format('Y-m-d') === (new DateTime())->format('Y-m-d') && $last === true) {
        $classes = 'py-2 px-2 border-l border-r border-b border-blue-500';
    }
@endphp

<td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>