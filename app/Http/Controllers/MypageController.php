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
}