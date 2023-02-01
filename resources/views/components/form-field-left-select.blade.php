<div {{ $attributes->merge(['class' => 'mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5']) }}>
    <label for="{{ $id ?? $name }}" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
        {{ isset($label) ? $label : ucfirst($name) }}
        @if(isset($required) && $required) <span class="text-red-500 text-sm">*</span> @endif
        {{--@if(isset($labelDescription) && $labelDescription) <span class="inline-block sm:block text-gray-500 text-xs font-light">{{ $labelDescription }}</span> @endif--}}
    </label>
    <div class="mt-1 sm:mt-0 sm:col-span-2">
        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
            <select id="{{ $id ?? $name }}" name="{{ $name }}"
                   @if(isset($value)) value="{{ $value }}" @endif
                   @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
                   @if(isset($required) && $required) required @endif
                   class="form-select block w-full sm:text-sm sm:leading-5 {{ $errors->has($name) ? ' is-invalid' : '' }}" >
                {{ $options }}
            </select>
        </div>
        @error($name)
        <div class="mt-1">
            <p class="error-message">{{ $message }}</p>
        </div>
        @enderror
    </div>
</div>
