@php
    $classes = "even:bg-black/30 h-20"
@endphp

<tr {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</tr>