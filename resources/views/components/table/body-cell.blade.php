@php
    $classes = "border-l border-white/20"
@endphp

<td {{ $attributes(['class' => $classes]) }}>{{ $slot }}</td>