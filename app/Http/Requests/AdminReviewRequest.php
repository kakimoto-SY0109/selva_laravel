<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|integer|exists:reviews,id',
            'product_id' => 'required|integer|exists:products,id',
            'member_id' => 'required|integer|exists:members,id',
            'evaluation' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => '商品を選択してください',
            'product_id.integer' => '商品の値が不正です',
            'product_id.exists' => '選択された商品が存在しません',
            'member_id.required' => '会員を選択してください',
            'member_id.integer' => '会員の値が不正です',
            'member_id.exists' => '選択された会員が存在しません',
            'evaluation.required' => '商品評価を選択してください',
            'evaluation.integer' => '商品評価の値が不正です',
            'evaluation.between' => '商品評価は1〜5の間で選択してください',
            'comment.required' => '商品コメントは必須です',
            'comment.max' => '商品コメントは500文字以内で入力してください',
        ];
    }
}