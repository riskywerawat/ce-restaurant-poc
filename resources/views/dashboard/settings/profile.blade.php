@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/settings.title'); ?>
@section('title', $pageTitle)

@section('content')
{{--    @include('dashboard._partials.breadcrumb', ['breadcrumbs' => ['บัญชีผู้ใช้ทั้งหมด' => route('dashboard.users.index')]])--}}
    <div class="form-container">

        <x-form-section action="{{ route('dashboard.settings.profile.update') }}">
            <x-slot name="title">
                {{ __('dashboard/settings.form.profile.title') }}
            </x-slot>
            <x-slot name="description">
                {{ __('dashboard/settings.form.profile.subtitle') }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-form-label for="name">{{ __('auth.form.name') }}</x-form-label>
                    <x-form-input id="name" type="text" name="name"
                                  autocomplete="name" value="{{ $user->name }}" />
                    <x-form-input-error for="name" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-form-button>
                    {{ __('common.save') }}
                </x-form-button>
            </x-slot>
        </x-form-section>

        {{--<div>--}}
            {{--<div class="md:grid md:grid-cols-3 md:gap-6">--}}
                {{--<div class="md:col-span-1">--}}
                    {{--<div class="px-4 sm:px-0">--}}
                        {{--<h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('dashboard/settings.form.profile.title') }}</h3>--}}
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">--}}
                            {{--{{ __('dashboard/settings.form.profile.subtitle') }}--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="mt-5 md:mt-0 md:col-span-2">--}}
                    {{--<form action="{{ route('dashboard.settings.profile.update') }}" method="POST">--}}
                        {{--@csrf--}}
                        {{--<div class="shadow sm:rounded-md sm:overflow-hidden">--}}
                            {{--<div class="px-4 py-5 bg-white sm:p-6">--}}
                                {{--<div class="grid grid-cols-3 gap-6">--}}
                                    {{--<div class="col-span-3 sm:col-span-2">--}}
                                        {{--<label for="username" class="block text-sm font-medium leading-5 text-gray-700">--}}
                                            {{--{{ __('auth.form.name') }}--}}
                                        {{--</label>--}}
                                        {{--<x-form-label for="name">--}}
                                            {{--{{ __('auth.form.name') }}--}}
                                        {{--</x-form-label>--}}
                                        {{--<div class="mt-1 flex rounded-md shadow-sm">--}}
                                            {{--<input class="form-input flex-1 block w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="John Doe"--}}
                                                   {{--name="name" value="{{ $user->name }}" id="name" />--}}
                                        {{--</div>--}}
                                        {{--@error('name')--}}
                                        {{--<p class="error-message">{{ $message }}</p>--}}
                                        {{--@enderror--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="mt-6">--}}
                                    {{--<label for="photo" class="block text-sm leading-5 font-medium text-gray-700">--}}
                                        {{--Photo--}}
                                    {{--</label>--}}
                                    {{--<div class="mt-2 flex items-center">--}}
                                        {{--<span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">--}}
                                          {{--<svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">--}}
                                            {{--<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />--}}
                                          {{--</svg>--}}
                                        {{--</span>--}}
                                        {{--<span class="ml-5 rounded-md shadow-sm">--}}
                                          {{--<button type="button" class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">--}}
                                            {{--Change--}}
                                          {{--</button>--}}
                                        {{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="px-4 py-3 bg-gray-50 text-right sm:px-6">--}}
                                {{--<span class="inline-flex rounded-md shadow-sm">--}}
                                  {{--<button type="submit" class="button button-primary">--}}
                                    {{--{{ __('common.save') }}--}}
                                  {{--</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <x-form-section-divider />

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('dashboard/settings.menu.password') }}</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            {{--Use a permanent address where you can receive mail.--}}
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('dashboard.settings.password.update') }}" method="POST">
                        @csrf
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <x-form-label for="current_password">
                                            {{ __('dashboard/settings.form.password.current_password') }}
                                        </x-form-label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input class="form-input flex-1 block w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                                                   type="password" name="current_password" value="" id="current_password" />
                                        </div>
                                        @error('current_password')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <x-form-label for="password">
                                            {{ __('dashboard/settings.form.password.new_password') }}
                                        </x-form-label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input class="form-input flex-1 block w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                   type="password" name="password" value="" id="password" />
                                        </div>
                                        @error('password')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <x-form-label for="password_confirmation">
                                            {{ __('dashboard/settings.form.password.new_password_confirmation') }}
                                        </x-form-label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input class="form-input flex-1 block w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                   type="password" name="password_confirmation" value="" id="password_confirmation" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button class="button button-primary">
                                    {{ __('dashboard/settings.menu.password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@section('js')--}}
    {{--@include('dashboard.shops._upload-photo-script')--}}
{{--@endsection--}}
