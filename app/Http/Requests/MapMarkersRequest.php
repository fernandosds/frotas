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
            'data.type' => 'required',
            'data.lenght_of_stay' => 'nullable|integer',
            'data.to_deliver' => 'nullable|boolean',
        ];

        return $return;
    }

    public function messages()
    {
        return [
            'data.markers.required' => 'Necessário informar as marcações da sua cerca',
            'data.name.required' => 'Por favor, dê um nome para sua cerca ',
            'data.type.required' => 'Por favor, selecione o tipo de cerca ',
            'data.lenght_of_stay.integer' => 'Tempo de permanência inválido ',
            'data.to_deliver.boolean' => 'Alertar veículos para entrega inválido ',
        ];
    }
}
