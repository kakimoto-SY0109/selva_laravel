<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $member = Auth::guard('member')->user();
        return view('profile.edit', compact('member'));
    }

    public function confirm(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $request->session()->put('profile_data', $data);
        
        return view('profile.confirm', ['data' => $data]);
    }

    public function back(Request $request)
    {
        $data = $request->session()->get('profile_data', []);
        return redirect()->route('profile.edit')->withInput($data);
    }

    public function update(Request $request)
    {
        $data = $request->session()->get('profile_data');
        
        if (!$data) {
            return redirect()->route('profile.edit')
                ->with('error', 'セッションが切れました。');
        }

        $member = Auth::guard('member')->user();
        $member->update([
            'name_sei' => $data['name_sei'],
            'name_mei' => $data['name_mei'],
            'nickname' => $data['nickname'],
            'gender' => $data['gender'],
        ]);

        $request->session()->forget('profile_data');

        return redirect()->route('mypage')->with('success', '会員情報を変更しました');
    }
}