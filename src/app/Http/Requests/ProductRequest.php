<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'name'    => ['required'],
            'price'     => ['required','integer','between:0,10000'],
            'description'        => ['required','string','max:120'],
            'seasons'         => ['required', 'array','min:1'],
            'seasons.*'         => ['exists:seasons,id'],
        ];

        if ($this->isMethod('post')) {  // 登録（store）時
            $rules['image'] = ['required', 'file', 'mimes:png,jpeg'];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {  // 更新（update）時
            $rules['image'] = ['nullable', 'file', 'mimes:png,jpeg']; // 画像の更新は任意
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'seasons.array' => '季節を選択してください',
            'seasons.min' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',    
        ];
    }
}
