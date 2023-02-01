<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('profile.password.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile.password.subtitle') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('profile.password.form.current_password') }}" />
            <x-jet-input id="current_password" for="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('profile.password.form.password') }}" />
            <x-jet-input id="password" for="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('profile.password.form.password_confirmation') }}" />
            <x-jet-input id="password_confirmation" for="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('common.response.save_success') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('common.save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
