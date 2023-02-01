<div class="mt-5">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ trans('dashboard/user.form.profile_information_title') }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
            {{ trans('dashboard/user.form.profile_information_description') }}
        </p>
    </div>
    <div class="mt-6 sm:mt-5">
        {{--<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">--}}
            {{--<label for="first_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">--}}
                {{--Name--}}
            {{--</label>--}}
            {{--<div class="mt-1 sm:mt-0 sm:col-span-2">--}}
                {{--<div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">--}}
                    {{--<input id="first_name" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        @include('dashboard._partials.formfield_left_label', [
            'label' => trans('dashboard/user.form.name'), 'name' => 'name', 'type' => 'text', 'value' => old('name', $user->name),
            'required' => true
        ])

        @include('dashboard._partials.formfield_left_label', [
            'label' => trans('dashboard/user.form.email'), 'name' => 'email', 'type' => 'email', 'value' => old('email', $user->email),
            'required' => true
        ])

        @if($user->id === auth()->user()->id)
        @include('dashboard._partials.formfield_left_label', [
            'label' => trans('dashboard/user.form.password'), 'name' => 'password', 'type' => 'password', 'value' => '',
        ])

        @include('dashboard._partials.formfield_left_label', [
            'label' => trans('dashboard/user.form.password_confirmation'), 'name' => 'password_confirmation', 'type' => 'password', 'value' => '',
        ])
        @endif

    </div>
</div>


