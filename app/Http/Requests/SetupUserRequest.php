<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SetupUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'key' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ];

        $user = User::findOrFail($this->key);
        if ($user->isUser()) {
            $rules['pin'] = 'required|digits:6|confirmed';
        }

        return $rules;
    }
}
