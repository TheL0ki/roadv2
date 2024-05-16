@php
    $classes = "hover:text-blue-400 duration-300";
@endphp

<a {{ $attributes(['class' => $classes])}}>{{ $slot }}</a>