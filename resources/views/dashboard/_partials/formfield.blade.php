<label class="form-label" for="{{ $id ?? $name }}">
    {{ isset($label) ? $label : ucfirst($name) }}
    @if(isset($labelDescription) && $labelDescription) <span class="ml-1 text-gray-600 text-xs font-light">{{ $labelDescription }}</span> @endif
    @if(isset($required) && $required) <span class="text-red-500 text-sm">*</span> @endif
</label>
<input class="form-input w-full {{ $errors->has($name) ? ' is-invalid' : '' }}"
       id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}"
       @if(isset($value)) value="{{ $value }}" @endif
       @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
       @if(isset($required) && $required) required @endif>
<div class="h-6">
    @error($name)
    <p class="error-message">{{ $message }}</p>
    @enderror
</div>
