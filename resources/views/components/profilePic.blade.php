@props(['path'])

@php
    $class = 'rounded-full';
@endphp

@if($path === NULL)
    <img src="{{ Vite::asset('resources/images/placeholder.png') }}" {{ $attributes(['class' => $class]) }}>
@else
    <img src="{{ Storage::url($path) }}" {{ $attributes(['class' => $class]) }}>
@endif