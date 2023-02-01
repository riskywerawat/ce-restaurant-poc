@extends('dashboard._layouts.base_no_layout')

@section('title', __('auth.sign_in'))

@section('content')
    <div class="min-h-screen bg-white dark:bg-slate-800 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md flex flex-col items-center">
            <img class="h-12 w-auto" src="{{ asset('images/logo-black.svg') }}" alt="RMS"/>
            {{--<h3 class="text-center text-2xl lg:text-3xl">RMS</h3>--}}
            <h2 class="mt-6 text-center text-3xl leading-9 font-bold text-black-100">
                {{ __('auth.sign_in') }}
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('dashboard.login') }}" method="POST">
                    @csrf()
                    <div>
                        <label for="email" class="form-label">
                            {{ __('auth.form.email') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="email" type="email" name="email" required
                                   class="form-input block w-full sm:text-sm sm:leading-5 {{ $errors->has('email') ? ' is-invalid' : '' }}"/>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="password" class="form-label">
                            {{ __('auth.form.password') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password" type="password" name="password" required
                                   class="form-input block w-full sm:text-sm sm:leading-5 {{ $errors->has('email') ? ' is-invalid' : '' }}"/>
                        </div>
                        @error('email')
                        <div class="my-1">
                            <p class="error-message">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" value="1"
                                   class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out"/>
                            <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                                {{ __('auth.form.remember') }}
                            </label>
                        </div>

                        {{--<div class="text-sm leading-5">--}}
                            {{--<a href="#"--}}
                               {{--class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">--}}
                                {{--{{ __('auth.form.forgot') }}--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button type="submit"
                                    class="w-full flex justify-center bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                              {{ __('auth.sign_in') }}
                            </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
