<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
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
                'type' => 'required',
                'chassi' => 'required|unique:cars',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'chassi' => [
                    'required',
                    Rule::unique('cars')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }
}
