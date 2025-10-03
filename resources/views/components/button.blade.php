@props(['type' => 'primary'])
@php
    $classes="text-white font-bold py-2 px-4 rounded duration-300";

    if($type === 'primary') {
        $classes .= ' bg-blue-800 hover:bg-blue-600';
    } else if($type === 'secondary') {
        $classes .= ' bg-neutral-700 hover:bg-neutral-800';
    } else if($type === 'danger') {
        $classes .= ' bg-red-500 hover:bg-red-700';
    } else if($type === 'success') {
        $classes .= ' bg-green-500 hover:bg-green-700';
    }
@endphp

<button {{ $attributes(['class' => $classes])}}>{{ $slot }}</button>