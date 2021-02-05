<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardingRequest extends FormRequest
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

       return [
           'contract_id'                => 'string|required',
           'device_id'                  => 'string|required',
           'source'                     => 'nullable|string|max:255',
           'destiny'                    => 'nullable|string|max:255',
           'transporter'                => 'nullable|string|max:255',
           'telephone'                  => 'nullable|max:14',
           'cell_phone'                 => 'nullable|max:14',
           'board'                      => 'nullable|string|max:255',
           'chassis'                    => 'nullable|max:255',
           'carts_plates'               => 'nullable|string|max:255',
           'transport_order'            => 'nullable|string|max:255',
           'amount_carried'             => 'nullable|string|max:255',
           'cpf_cnpj'                   => 'nullable|string|max:255',
           'brand'                      => 'nullable|string|max:255',
           'model'                      => 'nullable|string|max:255',
           'redundant_technologie'      => 'nullable|string|max:255',
           'type_of_load_id'            => 'nullable|integer',
           'accommodation_location_id'  => 'nullable|integer',

       ];
    }


}
