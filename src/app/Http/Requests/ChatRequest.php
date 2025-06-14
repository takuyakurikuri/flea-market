<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'image_path'=>['mimes:jpg,png'],
            'message'=>['required','max:400'],
        ];
    }

    public function messages(){
        return[
            'image_path.mimes' => '『.png』か『.jpeg』形式でアップロードしてください',
            'message.required' => '本文を入力して下さい',
            'message.max' => '本文は400文字以下にして下さい',
        ];
    }
}