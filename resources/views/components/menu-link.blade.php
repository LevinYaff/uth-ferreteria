@props(['active', 'icon'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium transition ease-in-out duration-150'
    : 'flex items-center px-4 py-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium transition ease-in-out duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if (isset($icon))
        <span class="mr-2">
            {{ $icon }}
        </span>
    @endif
    {{ $slot }}
</a>
