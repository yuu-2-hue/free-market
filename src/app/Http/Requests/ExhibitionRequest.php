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
            'image' => ['required', 'mimes:jpeg,png'],
            'category' => ['required'],
            'condition' => ['required'],
            'name' => ['required'],
            'explanation' => ['required', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品の画像をアップロードしてください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'explanation.required' => '商品の説明を入力してください',
            'explanation.max' => '255文字以内で入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '値段は数字で入力してください',
            'price.min' => '0円以上で入力してください',
        ];
    }
}
