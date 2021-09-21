<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapMarkersRequest extends FormRequest
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
            'data.markers' => 'required',
            'data.name' => 'required',
        ];

        return $return;
    }

    public function messages()
    {
        return [
            'data.markers.required' => 'Necessário informar as marcações',
            'data.name.required' => 'Por favor, dê um nome para suas marcações ',
        ];
    }
}
