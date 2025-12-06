<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}