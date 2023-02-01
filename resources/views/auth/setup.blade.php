<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        {{--<x-jet-validation-errors class="mb-4" />--}}
        <p class="my-4 text-center">Welcome to RMS, {{ $user->name }}</p>
        {{--<p class="my-4 text-center">Enter your new password and pin</p>--}}
        <form method="POST" action="{{ route('users.setup.store', ['token' => $request->route('token'), 'key' => $request->route('key')]) }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{--<div class="block">--}}
                {{--<x-jet-label value="{{ __('Email') }}" />--}}
                {{--<x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />--}}
            {{--</div>--}}

            <input type="hidden" name="key" value="{{ $user->id }}">

            <div class="mt-4">
                <x-jet-label value="{{ __('Password') }}" />
                <x-jet-input class="block mt-1 w-full" for="password" type="password" name="password" required autofocus
                             autocomplete="new-password" />
                <x-jet-input-error for="password" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Password') }}" />
                <x-jet-input class="block mt-1 w-full" for="password" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if($user->isUser())
            <div class="mt-4">
                <x-jet-label value="{{ __('Pin (number only, 6 digit)') }}" />
                <x-jet-input class="block mt-1 w-full" for="pin" type="password" name="pin" required autocomplete="new-pin"
                             maxlength="6" size="6" />
                <x-jet-input-error for="pin" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Pin') }}" />
                <x-jet-input class="block mt-1 w-full" for="pin" type="password" name="pin_confirmation" required
                             autocomplete="new-pin" maxlength="6" size="6" />
            </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <x-button-full class="w-full justify-center">
                    {{ $user->isUser() ? __('Set password and pin') : __('Set password') }}
                </x-button-full>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
