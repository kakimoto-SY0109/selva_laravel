<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|integer|exists:products,id',
            'name' => 'required|string|max:100',
            'member_id' => 'required|integer|exists:members,id',
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'product_subcategory_id' => 'required|integer|exists:product_subcategories,id',
            'image_1' => 'nullable|string',
            'image_2' => 'nullable|string',
            'image_3' => 'nullable|string',
            'image_4' => 'nullable|string',
            'product_content' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'name.max' => '商品名は100文字以内で入力してください。',
            'member_id.required' => '会員を選択してください。',
            'member_id.integer' => '会員の値が不正です。',
            'member_id.exists' => '選択された会員が存在しません。',
            'product_category_id.required' => '商品カテゴリ大を選択してください。',
            'product_category_id.integer' => '商品カテゴリ大の値が不正です。',
            'product_category_id.exists' => '選択された商品カテゴリ大が存在しません。',
            'product_subcategory_id.required' => '商品カテゴリ小を選択してください。',
            'product_subcategory_id.integer' => '商品カテゴリ小の値が不正です。',
            'product_subcategory_id.exists' => '選択された商品カテゴリ小が存在しません。',
            'product_content.required' => '商品説明は必須です。',
            'product_content.max' => '商品説明は500文字以内で入力してください。',
        ];
    }
}