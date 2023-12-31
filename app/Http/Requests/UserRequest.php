<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
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

        $return = [
            'name' => 'required|max:255',
            'customer_id' => 'integer',
        ];

        if ($this->method() == "POST") {
            $return = array_merge([
                'email' => 'email|required|max:255|unique:users,email,NULL,id,deleted_at,NULL',
                'password' => 'min:6|max:8|required_with:confirm_password|same:confirm_password',
                'password_confirmation' => 'min:6|max:8',
            ], $return);
        } elseif ($this->method() == "PUT") {
            $return = array_merge([
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($this->id)->whereNull('deleted_at'),
                ],
                'password' => 'same:confirm_password',
            ], $return);

        }

        return $return;
    }
}
