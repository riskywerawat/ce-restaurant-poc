@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-xs text-accent-red']) }}>{{ $message }}</p>
@enderror
