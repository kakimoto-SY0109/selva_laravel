<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Member;
use App\Mail\MemberRegistered;

class MemberController extends Controller
{
    public function showRegisterForm()
    {
        $genders = [
            1 => '男性',
            2 => '女性',
        ];
        
        return view('member.register', compact('genders'));
    }

    public function showConfirm(Request $request)
    {
        $validated = $request->validate([
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'email' => 'required|email|max:200|unique:members,email',
            'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/',
            'password_confirm' => 'required|same:password',
        ], [
            'name_sei.required' => '氏名（姓）は必須です',
            'name_sei.max' => '氏名（姓）は20文字以内で入力してください',
            'name_mei.required' => '氏名（名）は必須です',
            'name_mei.max' => '氏名（名）は20文字以内で入力してください',
            'nickname.required' => 'ニックネームは必須です',
            'nickname.max' => 'ニックネームは10文字以内で入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別を正しく選択してください',
            'email.required' => 'メールアドレスは必須です',
            'email.email' => '正しいメールアドレス形式で入力してください',
            'email.max' => 'メールアドレスは200文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは20文字以内で入力してください',
            'password.regex' => 'パスワードは半角英数字で入力してください',
            'password_confirm.required' => 'パスワード確認は必須です',
            'password_confirm.same' => 'パスワードが一致しません',
        ]);

        $request->session()->put('member_form', $validated);

        $genders = [
            1 => '男性',
            2 => '女性',
        ];

        return view('member.confirm', [
            'formData' => $validated,
            'genders' => $genders,
        ]);
    }

    public function backToForm(Request $request)
    {
        $formData = $request->session()->get('member_form', []);
        
        return redirect()->route('member.register')->withInput($formData);
    }

    public function register(Request $request)
    {
        $formData = $request->session()->get('member_form');

        if (!$formData) {
            return redirect()->route('member.register')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            $member = Member::create([
                'name_sei' => $formData['name_sei'],
                'name_mei' => $formData['name_mei'],
                'nickname' => $formData['nickname'],
                'gender' => $formData['gender'],
                'email' => $formData['email'],
                'password' => Hash::make($formData['password']),
            ]);

            // メール送信は失敗しても登録は完了させる
            try {
                Mail::to($member->email)->send(new MemberRegistered($member));
                Log::info('登録完了メール送信成功: ' . $member->email);
            } catch (\Exception $mailError) {
                // メール送信失敗してもログだけ残す
                Log::error('登録完了メール送信失敗: ' . $member->email . ' - ' . $mailError->getMessage());
            }

            $request->session()->forget('member_form');

            return view('member.complete', compact('member'));

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('会員登録DBエラー: ' . $e->getMessage());
            
            return redirect()->route('member.register')
                ->withInput()
                ->withErrors(['error' => 'データベースエラーが発生しました。しばらくしてから再度お試しください。']);
                
        } catch (\Exception $e) {
            Log::error('会員登録エラー: ' . $e->getMessage());
            
            return redirect()->route('member.register')
                ->withInput()
                ->withErrors(['error' => '登録処理中にエラーが発生しました。']);
        }
    }
}