@props(['value'])

<span {{ $attributes->merge(['class' => 'font-bold text-sky-400']) }}>
    {{ $value ?? $slot }}
</span>
