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

           'source'                     => 'string|max:255|required',
           'destiny'                    => 'string|max:255|required',
           'transporter'                => 'string|max:255|required',
           'telephone'                  => 'max:14',
           'cell_phone'                 => 'max:14',
           'board'                      => 'string|max:255|required',
           'chassis'                    => 'max:255',
           'carts_plates'               => 'string|max:255|required',
           'transport_order'            => 'string|max:255|required',
           'amount_carried'             => 'string|max:255|required',
           'cpf_cnpj'                   => 'string|max:255|required',
           'brand'                      => 'string|max:255|required',
           'model'                      => 'string|max:255|required',
           'redundant_technology'       => 'string|max:255|required',

           'type_of_load_id'            => 'integer|required',
           'accommodation_location_id'  => 'integer|required',

       ];
    }


}
