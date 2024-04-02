@props(['active' => false])

<li class="nav-item">
    <a 
        class="nav-link {{ $active ? 'active' : NULL }}" 
        aria-current="{{ $active ? 'page' : 'false' }}"
        {{ $attributes }}
    >
        {{ $slot }}
    </a>
</li>