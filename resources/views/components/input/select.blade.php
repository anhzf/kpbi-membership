@php
$classes = [
    'invalid' => 'border-red-300 border-2 bg-red-100',
];
@endphp

<div class="input-dropdown-container mb-4">
    <label for="{{ $name }}">
        {{ $label }}
    </label>
    <div class="relative">
        <select class="input-select @error($name){{ $classes['invalid'] }}@enderror" id="{{ $name }}" name="{{ $name }}" {{ $attributes ?? '' }}>
            @foreach ($choices as $choice)
                <option {{ !(($value ?? '') === $choice) ?:'selected' }}>{{ $choice }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <span class="material-icons">arrow_drop_down</span>
        </div>
    </div>
    {{ $slot ?? '' }}
</div>