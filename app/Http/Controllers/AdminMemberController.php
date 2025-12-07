<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Member;

class AdminMemberController extends Controller
{
    /**
     * 会員一覧・検索
     */
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $query = Member::query()->whereNull('deleted_at');

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        // 性別検索 OR
        if ($request->filled('gender')) {
            $query->whereIn('gender', $request->gender);
        }

        // フリーワード検索 AND
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name_sei', 'like', "%{$keyword}%")
                  ->orWhere('name_mei', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 並び替え
        $sortColumn = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        if (in_array($sortColumn, ['id', 'created_at'])) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('id', 'desc');
        }

        // ページ 10件ずつ
        $members = $query->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    /**
     * 会員登録フォーム表示
     */
    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $genders = [
            1 => '男性',
            2 => '女性',
        ];

        $isEdit = false;
        $member = null;

        return view('admin.members.form', compact('genders', 'isEdit', 'member'));
    }

    /**
     * 会員詳細表示
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $member = Member::findOrFail($id);

        $genders = [
            1 => '男性',
            2 => '女性',
        ];

        return view('admin.members.show', compact('member', 'genders'));
    }

    /**
     * 会員編集フォーム表示
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $member = Member::findOrFail($id);

        $genders = [
            1 => '男性',
            2 => '女性',
        ];

        $isEdit = true;

        return view('admin.members.form', compact('genders', 'isEdit', 'member'));
    }

    /**
     * 確認画面表示
     */
    public function confirm(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $isEdit = $request->input('is_edit', false);
        $memberId = $request->input('member_id');

        $rules = [
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'email' => [
                'required',
                'email',
                'max:200',
                $isEdit 
                    ? Rule::unique('members', 'email')->ignore($memberId)->whereNull('deleted_at')
                    : Rule::unique('members', 'email')->whereNull('deleted_at')
            ],
        ];

        if ($isEdit) {
            // 編集の場合、パスワードは任意
            if ($request->filled('password')) {
                $rules['password'] = 'min:8|max:20|regex:/^[a-zA-Z0-9]+$/';
                $rules['password_confirm'] = 'required|same:password';
            }
        } else {
            // 登録の場合、パスワードは必須
            $rules['password'] = 'required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/';
            $rules['password_confirm'] = 'required|same:password';
        }

        $messages = [
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
        ];

        $validated = $request->validate($rules, $messages);

        $request->session()->put('admin_member_form', array_merge($validated, [
            'is_edit' => $isEdit,
            'member_id' => $memberId,
        ]));

        $genders = [
            1 => '男性',
            2 => '女性',
        ];

        return view('admin.members.confirm', [
            'formData' => $validated,
            'genders' => $genders,
            'isEdit' => $isEdit,
            'memberId' => $memberId,
        ]);
    }

    /**
     * フォームに戻る
     */
    public function back(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $formData = $request->session()->get('admin_member_form', []);
        $isEdit = $formData['is_edit'] ?? false;
        $memberId = $formData['member_id'] ?? null;

        if ($isEdit && $memberId) {
            return redirect()->route('admin.members.edit', $memberId)->withInput($formData);
        } else {
            return redirect()->route('admin.members.create')->withInput($formData);
        }
    }

    /**
     * 会員登録処理
     */
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $formData = $request->session()->get('admin_member_form');

        if (!$formData || $formData['is_edit']) {
            return redirect()->route('admin.members.index')
                ->with('error', 'セッションが切れました。');
        }

        try {
            Member::create([
                'name_sei' => $formData['name_sei'],
                'name_mei' => $formData['name_mei'],
                'nickname' => $formData['nickname'],
                'gender' => $formData['gender'],
                'email' => $formData['email'],
                'password' => Hash::make($formData['password']),
            ]);

            $request->session()->forget('admin_member_form');

            return redirect()->route('admin.members.index')
                ->with('success', '会員を登録しました');

        } catch (\Exception $e) {
            return redirect()->route('admin.members.create')
                ->withInput()
                ->withErrors(['error' => '登録処理中にエラーが発生しました。']);
        }
    }

    /**
     * 会員更新処理
     */
    public function update(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $formData = $request->session()->get('admin_member_form');

        if (!$formData || !$formData['is_edit']) {
            return redirect()->route('admin.members.index')
                ->with('error', 'セッションが切れました。');
        }

        try {
            $member = Member::findOrFail($formData['member_id']);

            $updateData = [
                'name_sei' => $formData['name_sei'],
                'name_mei' => $formData['name_mei'],
                'nickname' => $formData['nickname'],
                'gender' => $formData['gender'],
                'email' => $formData['email'],
            ];

            // パスワードが入力されている場合のみ更新
            if (!empty($formData['password'])) {
                $updateData['password'] = Hash::make($formData['password']);
            }

            $member->update($updateData);

            $request->session()->forget('admin_member_form');

            return redirect()->route('admin.members.index')
                ->with('success', '会員情報を更新しました');

        } catch (\Exception $e) {
            return redirect()->route('admin.members.edit', $formData['member_id'])
                ->withInput()
                ->withErrors(['error' => '更新処理中にエラーが発生しました。']);
        }
    }

    /**
     * 会員削除（ソフトデリート）
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        try {
            $member = Member::findOrFail($id);

            $member->delete();

            // その会員に紐づく商品レビューもソフトデリート
            \DB::table('reviews')
                ->where('member_id', $id)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => now()]);

            return redirect()->route('admin.members.index')
                ->with('success', '会員を削除しました');

        } catch (\Exception $e) {
            return redirect()->route('admin.members.index')
                ->with('error', '削除処理中にエラーが発生しました');
        }
    }
}