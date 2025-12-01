<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();
        return view('mypage.index', compact('member'));
    }

    public function showWithdraw()
    {
        return view('mypage.withdraw');
    }

    public function withdraw()
    {
        $member = Auth::guard('member')->user();
        $member->delete();
        
        Auth::guard('member')->logout();
        
        return redirect()->route('top');
    }
}