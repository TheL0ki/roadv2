@props(['loopdate', 'last' => false])

@php
    $classes = "py-2 px-2";

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

<td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>