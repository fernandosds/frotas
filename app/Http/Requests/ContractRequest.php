<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
                'contract_number' => 'required|unique:contracts',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'contract_number' => [
                    'required',
                    Rule::unique('contracts')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }
}
