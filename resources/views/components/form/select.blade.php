@php
    $classes = "block
                w-full
                bg-neutral-700
                rounded-md
                border-neutral-500
                text-white
                py-1.5
                shadow-sm
                sm:text-sm
                sm:leading-6";
@endphp

<select {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</select>