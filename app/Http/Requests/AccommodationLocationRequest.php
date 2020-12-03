<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccommodationLocationRequest extends FormRequest
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

    public function rules()
    {

        $return = [];

        if ($this->method() == "POST") {
            $return = array_merge([
                'type' => 'required|unique:accommodation_locations',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'type' => [
                    'required',
                    Rule::unique('accommodation_locations')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }

}
