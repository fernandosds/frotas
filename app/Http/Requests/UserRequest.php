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
            'type' => 'required|string',
        ];

        if($this->method() == "POST"){
            $return = array_merge([
                'email' => 'email|required|max:255|unique:users',
                'password' => 'min:6|max:8|required_with:confirm_password|same:confirm_password',
                'password_confirmation' => 'min:6|max:8',
            ], $return);

        }elseif($this->method() == "PUT"){
            $return = array_merge([
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($this->id),
                ],
                'password' => 'same:confirm_password',
            ], $return);
        }

        return $return;

    }

}
