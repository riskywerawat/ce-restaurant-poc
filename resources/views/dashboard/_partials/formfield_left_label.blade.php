<div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
    <label for="{{ $id ?? $name }}" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
        {{ isset($label) ? $label : ucfirst($name) }}
        @if(isset($required) && $required) <span class="text-red-500 text-sm">*</span> @endif
        @if(isset($labelDescription) && $labelDescription) <span class="inline-block sm:block text-gray-500 text-xs font-light">{{ $labelDescription }}</span> @endif
    </label>
    <div class="mt-1 sm:mt-0 sm:col-span-2">
        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs bg-red-500">
          @if($type =='dropdown')
          <div class="inline-block relative w-full">
            <select  name="{{ $name }}" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has($name) ? ' is-invalid' : '' }}" required >
              <option value="">--- Select {{$name}} ---</option>
              @foreach ($dropdownList as $datas)
              @if($value === $datas['code'])
              <option selected value="{{ $datas['code'] }}">{{$datas['name']}}</option>
              @else
              <option value="{{ $datas['code'] }}">{{$datas['name']}}</option>
              @endif
              @endforeach
            </select>
            {{-- <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div> --}}
          </div>
                       {{-- @if(isset($dropdownList))
               <div class="inline-block relative w-full">
                <select class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                    <option value="">--- Select {{$name}}---</option>
                    @foreach ($dropdownList as $datas)
                    <option value="{{ $datas['code'] }}">{{$datas['name']}}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                  </div>
               </div>
                @endif --}}
                {{-- @if(isset($dropdownList))
                <select class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                    <option value="">--- Select {{$name}}---</option>
                    @foreach ($dropdownList as $datas)
                    <option value="{{ $datas['code'] }}">{{$datas['name']}}</option>
                    @endforeach
                </select>
                @endif --}}


            @else
            <input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}"
                   @if(isset($default)) value="{{ $default }}" @endif
                   @if(isset($value)) value="{{ $value }}" @endif
                   @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
                   @if(isset($required) && $required) required @endif
                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has($name) ? ' is-invalid' : '' }}" />
                   @endif
        </div>


        @error($name)

        <div class="mt-1">
            <p class="error-message" style="color:red">{{ $message }}</p>
        </div>
        @enderror
    </div>
</div>
