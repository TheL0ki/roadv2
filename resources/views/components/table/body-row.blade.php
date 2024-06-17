@php
    $classes = "even:bg-black/30"
@endphp

<tr {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</tr>