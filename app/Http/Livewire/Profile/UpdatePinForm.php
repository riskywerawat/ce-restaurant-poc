<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePinForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'current_password' => '',
        'pin' => '',
        'pin_confirmation' => '',
    ];

    /**
     * Update the user's password.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserPasswords  $updater
     * @return void
     */
    public function updatePin()
    {
        $this->resetErrorBag();

        $user = auth()->user();
        $input = $this->state;

        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'pin' => ['required', 'digits:6', 'confirmed'],
        ])->after(function ($validator) use ($user, $input) {
            if (! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePin');

        $user->pin = $input['pin'];
        $user->save();

        $this->state = [
            'current_password' => '',
            'pin' => '',
            'pin_confirmation' => '',
        ];

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.profile.update-pin-form');
    }
}
