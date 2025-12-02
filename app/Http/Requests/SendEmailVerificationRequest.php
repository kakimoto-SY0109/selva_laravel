<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SendEmailVerificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // 自分のメールアドレスは除外してチェック
        $member_id = Auth::guard('member')->id();
        
        return [
            'email' => "required|email|max:200|unique:members,email,{$member_id}",
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.max' => 'メールアドレスは200文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',
        ];
    }
}