<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'evaluation' => 'required|integer|in:1,2,3,4,5',
            'comment' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'evaluation.required' => '商品評価を選択してください',
            'evaluation.in' => '商品評価は1～5の値を選択してください',
            'comment.required' => '商品コメントを入力してください',
            'comment.max' => '商品コメントは500文字以内で入力してください',
        ];
    }
}