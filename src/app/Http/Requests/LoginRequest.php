<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => ['required', 'min:8'],
        ];
    }
    public function messages(){
        return [
            'email.required' =>'メールアドレスを入力して下さい',
            'password.required' =>'パスワードを入力して下さい',
            'password.min8' =>'パスワードは8桁以上で入力してください'
        ];
    }
}