<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        $rules =  [
            'name' => ['required'],
            'zipcode' => ['required','digits:7'],
            'address' => ['required'],
            //'building' => ['string'],
            'image_path' => ['mimes:jpg,png']
        ];


        if ($this->routeIs('address.change')) {
            return array_intersect_key($rules, array_flip(['zipcode', 'address']));
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力して下さい',
            'zipcode.required' => '郵便番号を入力して下さい',
            'zipcode.digits' => '郵便番号は7桁で入力して下さい',
            'address.required' => ' 住所を入力して下さい',
            //'building.string' => '文字で入力して下さい',
            'image_path.mimes' => '画像はjpgかpngにて設定ください'
        ];

    }
}