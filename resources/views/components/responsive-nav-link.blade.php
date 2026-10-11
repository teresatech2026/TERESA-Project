@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-accent-500 text-start text-base font-medium text-primary-700 bg-primary-50 dark:text-primary-200 dark:bg-primary-900/50 focus:outline-none focus:bg-primary-100 focus:border-accent-600 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-gray-200 hover:bg-primary-50 dark:hover:bg-gray-700 hover:border-primary-300 dark:hover:border-gray-600 focus:outline-none focus:text-primary-700 dark:focus:text-gray-200 focus:bg-primary-50 dark:focus:bg-gray-700 focus:border-primary-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>