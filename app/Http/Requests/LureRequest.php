<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LureRequest extends FormRequest
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
                'serial_number' => 'required|unique:lures',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'serial_number' => [
                    'required',
                    Rule::unique('lures')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }

}
