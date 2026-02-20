@props(['highlighted' => false])

@php
    $classes = "even:bg-black/30 h-20";
    if ($highlighted) {
        $classes .= " highlight-current-user-row";
    }
@endphp

<tr {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</tr>