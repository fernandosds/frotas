<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;
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
                'cpf' => 'required|unique:drivers',
                'card_number' => 'required|unique:drivers',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'cpf' => [
                    'required',
                    Rule::unique('drivers')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }
}
