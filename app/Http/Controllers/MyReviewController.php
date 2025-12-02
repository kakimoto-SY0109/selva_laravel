<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Http\Requests\UpdateReviewRequest;

class MyReviewController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();
        $reviews = Review::where('member_id', $member->id)
            ->with(['product.category', 'product.subcategory'])
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('my-reviews.index', compact('reviews'));
    }

    public function edit($id)
    {
        $member = Auth::guard('member')->user();
        $review = Review::where('id', $id)
            ->where('member_id', $member->id)
            ->with(['product.category', 'product.subcategory'])
            ->firstOrFail();

        return view('my-reviews.edit', compact('review'));
    }

    public function confirm(UpdateReviewRequest $request, $id)
    {
        $member = Auth::guard('member')->user();
        $review = Review::where('id', $id)
            ->where('member_id', $member->id)
            ->with(['product.category', 'product.subcategory'])
            ->firstOrFail();

        $data = $request->validated();
        $request->session()->put('review_edit_data', $data);
        $request->session()->put('review_edit_id', $id);

        return view('my-reviews.confirm', [
            'review' => $review,
            'data' => $data,
        ]);
    }

    public function back(Request $request, $id)
    {
        $data = $request->session()->get('review_edit_data', []);
        return redirect()->route('my-reviews.edit', $id)->withInput($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->session()->get('review_edit_data');
        $session_id = $request->session()->get('review_edit_id');

        if (!$data || $session_id != $id) {
            return redirect()->route('my-reviews.edit', $id)
                ->with('error', 'セッションが切れました。');
        }

        $member = Auth::guard('member')->user();
        $review = Review::where('id', $id)
            ->where('member_id', $member->id)
            ->firstOrFail();

        $review->update([
            'evaluation' => $data['evaluation'],
            'comment' => $data['comment'],
        ]);

        $request->session()->forget(['review_edit_data', 'review_edit_id']);

        return redirect()->route('my-reviews')->with('success', 'レビューを更新しました');
    }

    public function delete($id)
    {
        $member = Auth::guard('member')->user();
        $review = Review::where('id', $id)
            ->where('member_id', $member->id)
            ->with(['product.category', 'product.subcategory'])
            ->firstOrFail();

        return view('my-reviews.delete', compact('review'));
    }

    public function destroy($id)
    {
        $member = Auth::guard('member')->user();
        $review = Review::where('id', $id)
            ->where('member_id', $member->id)
            ->firstOrFail();

        $review->delete();

        return redirect()->route('my-reviews')->with('success', 'レビューを削除しました');
    }
}