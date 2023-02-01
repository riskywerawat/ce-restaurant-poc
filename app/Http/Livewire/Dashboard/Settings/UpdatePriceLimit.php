<?php

namespace App\Http\Livewire\Dashboard\Settings;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePriceLimit extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state;

    public function mount()
    {
        $priceLimit = SiteSetting::priceLimit();
        $this->state = [
            'max_bid_price' => $priceLimit->setting['max_bid_price'] ? $priceLimit->setting['max_bid_price']/100 : null, // satang
            'max_ask_price' => $priceLimit->setting['max_ask_price'] ? $priceLimit->setting['max_ask_price']/100 : null, // satang
        ];
    }

    public function submit()
    {
        $this->resetErrorBag();

//        $user = auth()->user();
        $input = $this->state;

        Validator::make($input, [
            'max_bid_price' => ['nullable', 'numeric'],
            'max_ask_price' => ['nullable', 'numeric'],
        ])->validateWithBag('priceLimit');

        SiteSetting::updatePriceLimit($input);

        $this->state = [
            'max_bid_price' => $input['max_bid_price'],
            'max_ask_price' => $input['max_ask_price'],
        ];

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.update-price-limit');
    }
}
