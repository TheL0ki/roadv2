@props(['value' => null])

<input 
    type="date"
    class="
        block
        w-full 
        bg-neutral-500 
        rounded-md 
        border-0 
        py-1.5 
        shadow-sm 
        ring-1 
        ring-inset 
        ring-gray-300 
        focus:ring-2 
        focus:ring-inset 
        focus:ring-blue-400 
        sm:text-sm sm:leading-6"

    {{ $attributes }}

    @if ($value !== null)
        value="{{ $value }}"
    @endif
>