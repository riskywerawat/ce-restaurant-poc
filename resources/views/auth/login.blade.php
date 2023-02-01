<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-accent-green">
                {{ session('status') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-4 font-medium text-sm text-kimberly-primary">
                {{ session('info') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Password') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-kimberly-inactive">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col items-center justify-center mt-4">
                <x-button-full class="w-full justify-center">
                    {{ __('Login') }}
                </x-button-full>
                @if (Route::has('password.request'))
                    <p class="mt-3 text-xs text-kimberly-inactive">
                        {{ __('Forgot your password?') }}
                        <a class="underline text-kimberly-link hover:text-kimberly-primary" href="{{ route('password.request') }}">
                            {{ __('Reset password') }}
                        </a>
                    </p>
                @endif
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
