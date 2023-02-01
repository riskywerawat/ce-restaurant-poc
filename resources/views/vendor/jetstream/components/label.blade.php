@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-kimberly-primary']) }}>
    {{ $value ?? $slot }}
</label>
