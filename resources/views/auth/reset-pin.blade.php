<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        <p class="my-4 text-center">Enter your new pin</p>
        <form method="POST" action="{{ route('users.reset.pin.submit') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{--<div class="block">--}}
                {{--<x-jet-label value="{{ __('Email') }}" />--}}
                {{--<x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />--}}
            {{--</div>--}}

            <div class="mt-4">
                <x-jet-label value="{{ __('Pin') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="pin" required autocomplete="new-pin" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Pin') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="pin_confirmation" required autocomplete="new-pin" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-button-full class="w-full justify-center">
                    {{ __('Reset Pin') }}
                </x-button-full>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
