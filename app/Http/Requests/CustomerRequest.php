<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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

        $return = [
            'address' => 'required',
            'cep' => 'required|string',
            'number' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
        ];

        if ($this->method() == "POST") {
            $return = array_merge([
                'cpf_cnpj' => 'required|unique:customers'
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'cpf_cnpj' => [
                    'required',
                    Rule::unique('customers')->ignore($this->id),
                ],

            ], $return);
        }

        return $return;
    }
}
