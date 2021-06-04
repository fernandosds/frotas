<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DriverRequest extends FormRequest
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
        $return = [];

        if ($this->method() == "POST") {
            $return = array_merge([
                'cpf' => Rule::unique('drivers')->where(function ($query) {
                    return $query->where('customer_id', Auth::user()->customer_id)->where('deleted_at', null);
                }),
                'card_id' => 'required',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'cpf' => Rule::unique('drivers')->ignore($this->id)->where(function ($query) {
                    return $query->where('customer_id', Auth::user()->customer_id);
                }),
                'card_id' => 'required',
            ], $return);
        }

        return $return;
    }
}
