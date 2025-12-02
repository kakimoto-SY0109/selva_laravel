<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'auth_code' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'auth_code.required' => '認証コードを入力してください',
            'auth_code.numeric' => '認証コードは数値で入力してください',
        ];
    }
}