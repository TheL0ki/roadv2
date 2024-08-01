@props(['path'])

@php
    $class = 'rounded-full';
@endphp

@if($path === NULL)
    <img src="{{ Vite::asset('resources/images/profilePlaceholder.png') }}" {{ $attributes(['class' => $class]) }}>
@else
    <img src="{{ Vite::asset('storage/app/' . $path) }}" {{ $attributes(['class' => $class]) }}>
@endif