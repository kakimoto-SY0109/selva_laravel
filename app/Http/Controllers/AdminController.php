<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrator;

class AdminController extends Controller
{
    public function top()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.top');
    }

    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.top');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => [
                'required',
                'regex:/^[a-zA-Z0-9]+$/',
                'min:7',
                'max:10'
            ],
            'password' => [
                'required',
                'regex:/^[a-zA-Z0-9]+$/',
                'min:8',
                'max:20'
            ],
        ], [
            'login_id.required' => 'ログインIDを入力してください',
            'login_id.regex' => 'ログインIDは半角英数字で入力してください',
            'login_id.min' => 'ログインIDは7文字以上で入力してください',
            'login_id.max' => 'ログインIDは10文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.regex' => 'パスワードは半角英数字で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは20文字以内で入力してください',
        ]);

        $admin = Administrator::where('login_id', $request->login_id)
                              ->whereNull('deleted_at')
                              ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('admin.top');
        }

        return back()
            ->withInput($request->only('login_id'))
            ->withErrors(['login' => 'ログインIDまたはパスワードが正しくありません']);
    }

    public function logout(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}