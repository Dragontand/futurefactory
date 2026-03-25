@php
    $classes = "font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight";
@endphp

<h2 {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</h2>