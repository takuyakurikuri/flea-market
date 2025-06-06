<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image_path'=>['required','mimes:jpg,png'],
            'condition'=>['required'],
            'name'=>['required','string'],
            'detail'=>['required','max:255'],
            'price'=>['required','integer','min:1'],
            'category_id' => ['required', 'min:1'],
        ];

    }
    public function messages()
    {
        return [
            'image_path.required' => '商品画像を設定して下さい',
            'image_path.mimes' => '商品画像はjpegかpngで設定して下さい',
            'condition.required' => '商品の状態を選択して下さい',
            'name.required' => '商品の名前を入力して下さい',
            'detail.required' => '商品の説明を入力して下さい',
            'detail.max' => '商品の説明は255文字以下にして下さい',
            'price.required' => '金額を設定して下さい',
            'price.integer' => '金額を数値で入力して下さい',
            'price.min' => '金額は0円以上で設定して下さい',
            'category_id.required' => 'カテゴリを1つ以上選択してください。',
            'category_id.min'      => 'カテゴリを1つ以上選択してください。',
        ];
    }
}