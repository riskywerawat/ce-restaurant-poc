<x-form-section submit="submit">
    <x-slot name="title">
        {{ __('Price Limit') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Users are not allow to enter price higher than limit.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-2">
            <x-form-label for="max_bid_price" value="{{ __('Max Bid Price') }}" />
            <x-form-input id="max_bid_price" for="max_bid_price" type="number" class="mt-1 block w-full" suffix="Baht"
                         wire:model.defer="state.max_bid_price" />
            <x-form-input-error for="max_bid_price" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-2">
            <x-form-label for="max_ask_price" value="{{ __('Max Offer Price') }}" />
            <x-form-input id="max_ask_price" for="max_ask_price" type="number" class="mt-1 block w-full" suffix="Baht"
                         wire:model.defer="state.max_ask_price" />
            <x-form-input-error for="max_ask_price" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-form-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-form-action-message>

        <x-form-button>
            {{ __('Save') }}
        </x-form-button>
    </x-slot>
</x-form-section>


