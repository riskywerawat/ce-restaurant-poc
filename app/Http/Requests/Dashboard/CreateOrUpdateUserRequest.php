<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateUserRequest extends FormRequest
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
            'name'      => 'required|string|max:255',
            'role'      => 'required|in:1,2,buyer,seller',
        ];

        if ($this->getMethod() == 'POST') { // create
            $rules += ['email'      => 'required|email|unique:users,email|max:255'];
//            $rules += ['password'   => 'required|min:6|confirmed'];
        } else { // update
            $user = $this->route('user');
            $rules += ['email'      => 'required|email|unique:users,email,'.$user->id.'|max:255'];
//            $rules += ['password'   => 'nullable|min:6|confirmed'];
        }

        return $rules;
    }
}
