@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-xs text-accent-red mt-1']) }}>{{ $message }}</p>
@enderror
