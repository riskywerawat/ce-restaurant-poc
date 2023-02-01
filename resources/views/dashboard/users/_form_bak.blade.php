{{--<div class="flex flex-col p-2 w-full items-center justify-center mb-4">--}}
    {{--<label class="w-48 h-48 sm:w-64 sm:h-64 flex flex-col items-center form-input bg-white uppercase hover:shadow-lg--}}
                {{--cursor-pointer hover:bg-gray-100 p-0 overflow-hidden relative{{ $errors->has('photo') ? ' is-invalid' : '' }}">--}}
        {{--<img id="preview-image" src="{{ $user->photo_optimized_raw }}" alt="preview image"--}}
             {{--class="object-cover @if(!$user->hasPhoto()) hidden @endif w-full h-full">--}}
        {{--<div class="w-full h-full flex flex-col justify-center items-center @if($user->hasPhoto()) hidden @endif" id="upload-photo-icon">--}}
            {{--<svg  class="w-3/4 h-3/4" fill="currentColor"--}}
                  {{--xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
                {{--<path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />--}}
            {{--</svg>--}}
            {{--<span class="mt-2 text-base leading-normal">อัพโหลดรูป</span>--}}
        {{--</div>--}}
        {{--<div class="absolute right-0 bottom-0 w-8 pr-1 pb-1 flex justify-end @if(!$user->hasPhoto()) hidden @endif image-upload-badge" id="upload-photo-badge">--}}
            {{--<svg class="w-5 h-5 fill-current z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 10v6H7v-6H2l8-8 8 8h-5zM0 18h20v2H0v-2z"/></svg>--}}
        {{--</div>--}}
        {{--<input type="file" name="photo" class="hidden" onchange="loadFile(event)" accept='image/*' />--}}
    {{--</label>--}}
    {{--<div class="h-6">--}}
        {{--@error('photo')--}}
        {{--<p class="error-message">{{ $message }}</p>--}}
        {{--@enderror--}}
    {{--</div>--}}
{{--</div>--}}
<div class="w-full sm:w-1/2 px-2 mb-4">
    @include('dashboard._partials.formfield', [
        'label' => 'ชื่อ', 'name' => 'name', 'type' => 'text', 'value' => $user->name ?? old('name'),
        'required' => true
    ])
</div>
<div class="w-full sm:w-1/2 px-2 mb-4">
    @include('dashboard._partials.formfield', [
        'label' => 'อีเมล', 'name' => 'email', 'type' => 'email', 'value' => $user->email ?? old('email'),
        'required' => true
    ])
</div>
<div class="w-full sm:w-1/2 px-2">
    @include('dashboard._partials.formfield', [
        'label' => __('auth.form.password'), 'name' => 'password', 'type' => 'password', 'value' => '',
    ])
</div>
<div class="w-full sm:w-1/2 px-2">
    @include('dashboard._partials.formfield', [
        'label' => __('auth.form.password_confirmation'), 'name' => 'password_confirmation', 'type' => 'password', 'value' => '',
    ])
</div>

@can('updateRole', $user)
<div class="w-full px-2 mb-8">
    <label class="form-label">
        Role
    </label>
    <div class="flex flex-wrap -mx-2">
        @foreach($roles as $role)
            <label class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex items-center px-2 mb-2 cursor-pointer">
                <input type="checkbox" class="form-checkbox" name="roles[]" value="{{ $role->id }}"
                       @if($user->hasRole($role)) checked @endif>
                <span class="ml-2 capitalize whitespace-no-wrap">{{ snakeCaseToText($role->name) }}</span>
            </label>
        @endforeach
    </div>
</div>
@endcan
