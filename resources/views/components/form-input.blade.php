@props(['disabled' => false, 'suffix' => null])

<?php $class = 'form-input block w-full';
if($errors->get($attributes['name'])) {
    $class .= ' border-red-500';
}
?>
<div class="mt-1 relative rounded-md shadow-sm">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $class]) !!}>
    @if(isset($suffix))
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
      <span class="text-gray-500 sm:text-sm sm:leading-5" id="price-currency">
        {{ $suffix }}
      </span>
    </div>
    @endif
</div>
