@php
$classes = [
    'invalid' => 'border-red-600 bg-red-100',
];
@endphp

<div {{ $attributes->merge(['class' => 'input-text-container mb-4']) }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        name="{{ $name }}"
        class="input-text @error($name){{ $classes['invalid'] }}@enderror"
        value="{{ $value ?? '' }}"
        {{ $attributes ?? '' }}
    >
    {{ $slot }}
</div>