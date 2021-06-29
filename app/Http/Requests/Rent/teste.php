<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        "date" => 'required|date|after:tomorrow',
        "period" => 'required',
        "posto" => 'required',
        "solicitacao" => 'required',
    }

    public function messages()
    {

        return [
            "required" => 'O :attribute é obrigatório',
            'date.after' => 'A :attribute deve ser futura',
        ];
    }
}
