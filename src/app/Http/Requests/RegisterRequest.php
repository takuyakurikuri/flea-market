<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Fortify\PasswordValidationRules;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => ['required', 'min:8','confirmed'],
        ];
    }

    public function messages(){
        return [
            'name.required' =>'お名前を入力して下さい',
            'email.required' =>'メールアドレスを入力して下さい',
            'password.required' =>'パスワードを入力して下さい',
            'password.min' =>'パスワードを8桁以上で入力して下さい',
            'password.confirmed' => 'パスワードと一致しません'
        ];
    }
}