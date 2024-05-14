@php
    $classes = "border-l border-white/20 py-2 px-2"
@endphp

<td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>