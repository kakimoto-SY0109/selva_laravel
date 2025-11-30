<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class AuthController extends Controller
{
    // トップページ
    public function top()
    {
        return view('member.top');
    }

    // ログインフォーム
    public function showLogin()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('top');
        }
        return view('member.login');  // member/login.blade.php
    }

    // ログイン処理
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'IDもしくはパスワードが間違っています',
            'email.email' => 'IDもしくはパスワードが間違っています',
            'password.required' => 'IDもしくはパスワードが間違っています',
        ]);

        $member = Member::where('email', $request->email)
                       ->whereNull('deleted_at')
                       ->first();

        if ($member && Hash::check($request->password, $member->password)) {
            Auth::guard('member')->login($member);
            $request->session()->regenerate();
            return redirect()->route('top');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['login' => 'IDもしくはパスワードが間違っています']);
    }

    // ログアウト
    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('top');
    }
}