<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_sei' => 'required|string|max:20',
            'name_mei' => 'required|string|max:20',
            'nickname' => 'required|string|max:10',
            'gender' => 'required|integer|in:1,2',
        ];
    }

    public function messages()
    {
        return [
            'name_sei.required' => '氏名（姓）は必須です',
            'name_sei.max' => '氏名（姓）は20文字以内で入力してください',
            'name_mei.required' => '氏名（名）は必須です',
            'name_mei.max' => '氏名（名）は20文字以内で入力してください',
            'nickname.required' => 'ニックネームは必須です',
            'nickname.max' => 'ニックネームは10文字以内で入力してください',
            // チェック不要　※一応置いとく
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別を正しく選択してください',
        ];
    }
}