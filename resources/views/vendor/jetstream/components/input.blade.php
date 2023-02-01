@props(['disabled' => false, 'for' => null])

<?php $class = 'form-input rounded-md shadow-sm';
    if($errors->get($for)) {
        $class .= ' border-accent-red';
    }
?>
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $class]) !!}>
