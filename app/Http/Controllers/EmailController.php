<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendEmailVerificationRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Mail\EmailVerification;

class EmailController extends Controller
{
    public function edit()
    {
        $member = Auth::guard('member')->user();
        return view('email.edit', compact('member'));
    }

    public function send(SendEmailVerificationRequest $request)
    {
        $member = Auth::guard('member')->user();
        // 認証コード生成（6桁）
        $code = rand(100000, 999999);
        
        $member->update([
            'auth_code' => $code,
        ]);

        $request->session()->put('new_email', $request->email);

        Mail::to($request->email)->send(new EmailVerification($code));

        return redirect()->route('email.verify');
    }

    public function verify()
    {
        return view('email.verify');
    }

    public function complete(VerifyEmailRequest $request)
    {
        $member = Auth::guard('member')->user();
        $new_email = $request->session()->get('new_email');

        if (!$new_email) {
            return redirect()->route('email.edit')
                ->withErrors(['error' => 'セッションが切れました。']);
        }

        // 認証コード判定
        if ($request->auth_code != $member->auth_code) {
            return redirect()->route('email.verify')
                ->withInput()
                ->withErrors(['auth_code' => '認証コードが正しくありません']);
        }

        $member->update([
            'email' => $new_email,
            'auth_code' => null,
        ]);

        $request->session()->forget('new_email');

        return redirect()->route('mypage')->with('success', 'メールアドレスを変更しました');
    }
}