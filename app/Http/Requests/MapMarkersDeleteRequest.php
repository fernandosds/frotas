<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapMarkersDeleteRequest extends FormRequest
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

        $return = [
            'data.id' => 'required',
            'data.name' => 'required',
        ];

        return $return;
    }

    public function messages()
    {
        return [
            'data.id.required' => 'Informe o ID da cerca',
            'data.name.required' => 'Por favor, informe o nome da cerca'
        ];
    }
}
