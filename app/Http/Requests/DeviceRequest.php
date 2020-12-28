<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
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

        $id = $this->route('post');

        $return = [];

        if ($this->method() == "POST") {
            $return = array_merge([
                'model' => 'required|unique:devices,model,{$id},id,deleted_at,NULL',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'model' => [
                    'required',
                    Rule::unique('devices')->ignore($this->id),
                ],
            ], $return);
        }

        return $return;
    }

}
