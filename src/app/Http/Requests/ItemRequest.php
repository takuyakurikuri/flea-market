<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'exhibitor_id'=>['required'],
            'item_image_path'=>['required','string','mimes:jpg,png'],
            //'item_category_id'=>['required'],
            //'condition_id'=>['required'],
            'condition'=>['required'],
            'item_name'=>['required','string'],
            'item_brand'=>['required'],
            'item_detail'=>['required','max:255'],
            'item_price'=>['required','integer','min:1']
        ];

    }
    public function messages()
    {
        return [
            
        ];
    }
}