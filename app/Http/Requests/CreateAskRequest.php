<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateAskRequest extends FormRequest
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
            'quantity'      => 'required|numeric|min:1000',
            'price'         => ['required', 'numeric'],
            'delivery_date' => 'required|array|min:1',
            'delivery_date.*' => 'date_format:Y-m-d',
        ];

        $maxAskPrice = maxAskPrice();
        if ($maxAskPrice) {
            $rules['price'][] = 'max:'.$maxAskPrice;
        }
        return $rules;
    }
}
