<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /**
     * パスワード再設定フォーム表示(メール送信)
     */
    public function showResetRequestForm()
    {
        return view('member.password-reset-request');
    }

    /**
     * パスワード再設定メール送信
     */
    public function sendResetLinkEmail(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => ['required', 'email', 'exists:members,email'],
        ], [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しいメールアドレス形式で入力してください',
            'email.exists' => '登録されていないメールアドレスです',
        ]);

        // 会員情報取得(Eloquent使用)
        $member = Member::where('email', $request->email)->first();

        // パスワード再設定メール送信
        Mail::to($member->email)->send(new PasswordResetMail($member));

        // 完了画面へリダイレクト
        return redirect()->route('member.password.sent');
    }

    /**
     * メール送信完了画面表示
     */
    public function showResetSent()
    {
        return view('member.password-reset-sent');
    }

    /**
     * パスワード再設定画面表示(パスワード入力)
     */
    public function showResetForm(Request $request)
    {
        $email = $request->email;

        // メールアドレスの存在確認(Eloquent使用)
        $member = Member::where('email', $email)->first();

        if (!$member) {
            return redirect()->route('member.password.request')
                ->withErrors(['email' => '無効なURLです。']);
        }

        return view('member.password-reset-form', compact('email'));
    }

    /**
     * パスワード更新処理
     */
    public function resetPassword(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => ['required', 'email', 'exists:members,email'],
            'password' => ['required', 'regex:/^[a-zA-Z0-9]+$/', 'min:8', 'max:20', 'confirmed'],
        ], [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しいメールアドレス形式で入力してください',
            'email.exists' => '登録されていないメールアドレスです',
            'password.required' => 'パスワードを入力してください',
            'password.regex' => 'パスワードは半角英数字で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは20文字以内で入力してください',
            'password.confirmed' => 'パスワードが一致しません',
        ]);

        // パスワード更新(Eloquent使用)
        $member = Member::where('email', $request->email)->first();
        
        if (!$member) {
            return back()->withErrors(['email' => '会員情報が見つかりません。'])
                ->withInput($request->only('email'));
        }

        $member->password = Hash::make($request->password);
        $member->save();

        // ログイン処理
        Auth::guard('member')->login($member);

        // トップ画面へリダイレクト
        return redirect()->route('top');
    }
}