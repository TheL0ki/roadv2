@php
    $classes="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded duration-300"
@endphp

<button {{ $attributes(['class' => $classes])}}>{{ $slot }}</button>