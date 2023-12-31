<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeOfLoadRequest extends FormRequest
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
                'type' => 'required|unique:types_of_loads',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'type' => [
                    'required',
                    Rule::unique('types_of_loads')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }

    
}
