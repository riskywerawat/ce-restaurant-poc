<x-jet-form-section submit="updatePin">
    <x-slot name="title">
        {{ __('Update Pin') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your pin is random. Avoid using sequential pin to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" for="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="pin" value="{{ __('New Pin') }}" />
            <x-jet-input id="pin" for="pin" type="password" class="mt-1 block w-full" wire:model.defer="state.pin" autocomplete="new-pin" />
            <x-jet-input-error for="pin" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="pin_confirmation" value="{{ __('Confirm Pin') }}" />
            <x-jet-input id="pin_confirmation" for="pin_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.pin_confirmation" autocomplete="new-pin" />
            <x-jet-input-error for="pin_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

