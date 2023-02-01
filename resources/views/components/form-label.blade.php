@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm leading-5 text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
