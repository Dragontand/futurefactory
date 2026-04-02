@props(['value'])

<a {{ $attributes->merge(['class' => 'text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 hover:underline']) }}>
    {{ $value ?? $slot }}
</a>