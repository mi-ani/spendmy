@props(['active'])

@php
$classes = ($active ?? false)
            ? 'py-2 px-4 w-full menu-item--active font-semibold hover:bg-stoke hover:bg-opacity-80'
            : 'py-2 px-4 w-full hover:bg-stoke hover:bg-opacity-80';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
