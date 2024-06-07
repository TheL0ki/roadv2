@php
    $classes = "p-1 bg-black/40 w-full text-center";
@endphp

<select {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</select>