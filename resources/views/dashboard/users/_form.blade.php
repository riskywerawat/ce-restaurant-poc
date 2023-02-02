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

<div class="mt-8 border-t border-gray-200 pt-8 sm:mt-5 sm:pt-10">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Roles
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
            {{ trans('dashboard/user.form.role_description') }}
        </p>
    </div>
    <div class="mt-6 sm:mt-5">
        <div class="sm:border-t sm:border-gray-200 sm:pt-5">
            <div role="group" aria-labelledby="label-email">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-baseline">
                    <div>
                        <div class="text-base leading-6 font-medium text-gray-900 sm:text-sm sm:leading-5 sm:text-gray-700" id="label-email">
                            Roles
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:col-span-2">
                        {{--@foreach($roles as $role)--}}
                        {{--<div class="max-w-lg mt-4">--}}
                            {{--<div class="relative flex items-start">--}}
                                {{--<div class="flex items-center h-5">--}}
                                    {{--<input id="role-{{ $role->name }}" type="radio" name="role" value="{{ $role->id }}"--}}
                                            {{--@if($user->hasRole($role) || in_array($role->id, old('roles', []))) checked @endif--}}
                                           {{--class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 text-sm leading-5">--}}
                                    {{--<label for="role-{{ $role->name }}" class="font-medium text-gray-700 capitalize">{{ snakeCaseToText($role->name) }}</label>--}}
                                    {{--<p class="text-gray-500">{{ $role->present()->description }}</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@endforeach--}}

                        @if(auth()->user()->isSuperAdmin())
                        <?php $superAdminRole = $roles->firstWhere('name', \App\Models\Role::SUPER_ADMIN); ?>
                        <div class="max-w-lg mt-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="role-{{ $superAdminRole->name }}" type="radio" name="role" value="{{ $superAdminRole->id }}"
                                        @if($user->hasRole($superAdminRole) || in_array($superAdminRole->id, old('roles', []))) checked @endif
                                        class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </div>
                                <div class="ml-3 text-sm leading-5">
                                    <label for="role-{{ $superAdminRole->name }}" class="font-medium text-gray-700 capitalize">{{ snakeCaseToText($superAdminRole->name) }}</label>
                                    <p class="text-gray-500">{{ $superAdminRole->present()->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <?php $adminRole = $roles->firstWhere('name', \App\Models\Role::ADMIN); ?>
                        <div class="max-w-lg mt-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="role-{{ $adminRole->name }}" type="radio" name="role" value="{{ $adminRole->id }}"
                                           @if($user->hasRole($adminRole) || in_array($adminRole->id, old('roles', []))) checked @endif
                                           class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </div>
                                <div class="ml-3 text-sm leading-5">
                                    <label for="role-{{ $adminRole->name }}" class="font-medium text-gray-700 capitalize">{{ snakeCaseToText($adminRole->name) }}</label>
                                    <p class="text-gray-500">{{ $adminRole->present()->description }}</p>
                                </div>
                            </div>
                        </div>



                        <x-form-input-error for="role"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
