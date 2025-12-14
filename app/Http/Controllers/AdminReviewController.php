<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use App\Models\Product;
use App\Models\Member;
use App\Http\Requests\AdminReviewRequest;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $freeword = $request->input('freeword');
        $sortColumn = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'desc');

        $allowedSortColumns = ['id', 'created_at'];
        if (!in_array($sortColumn, $allowedSortColumns)) {
            $sortColumn = 'id';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query = Review::query()
            ->with(['member', 'product']);

        if (!empty($id)) {
            $query->where('id', $id);
        }

        if (!empty($freeword)) {
            $query->where('comment', 'like', "%{$freeword}%");
        }

        $query->orderBy($sortColumn, $sortDirection);
        $reviews = $query->paginate(10)->appends($request->query());

        return view('admin.reviews.index', compact(
            'reviews',
            'id',
            'freeword',
            'sortColumn',
            'sortDirection'
        ));
    }

    /**
     * 登録フォーム表示
     */
    public function create()
    {
        $products = Product::all();
        $members = Member::all();

        return view('admin.reviews.form', [
            'review' => null,
            'isEdit' => false,
            'products' => $products,
            'members' => $members,
        ]);
    }

    /**
     * 編集フォーム表示
     */
    public function edit($id)
    {
        $review = Review::with(['member', 'product'])->findOrFail($id);
        $products = Product::all();
        $members = Member::all();

        return view('admin.reviews.form', [
            'review' => $review,
            'isEdit' => true,
            'products' => $products,
            'members' => $members,
        ]);
    }

    /**
     * 確認画面表示
     */
    public function confirm(AdminReviewRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('admin_review_form', $validated);

        $isEdit = !empty($validated['id']);

        $product = Product::find($validated['product_id']);
        $member = Member::find($validated['member_id']);

        // 総合評価
        $averageRating = Review::where('product_id', $validated['product_id'])->avg('evaluation');
        $averageRating = $averageRating ? ceil($averageRating) : 0;

        return view('admin.reviews.confirm', [
            'formData' => $validated,
            'isEdit' => $isEdit,
            'product' => $product,
            'memberName' => $member ? $member->name_sei . ' ' . $member->name_mei : '',
            'averageRating' => $averageRating,
        ]);
    }

    /**
     * フォームに戻る
     */
    public function back(Request $request)
    {
        $formData = $request->session()->get('admin_review_form', []);
        $isEdit = !empty($formData['id']);

        if ($isEdit) {
            return redirect()->route('admin.reviews.edit', $formData['id'])
                ->withInput($formData);
        } else {
            return redirect()->route('admin.reviews.create')
                ->withInput($formData);
        }
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $formData = $request->session()->get('admin_review_form');

        if (!$formData) {
            return redirect()->route('admin.reviews.create')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            Review::create([
                'product_id' => $formData['product_id'],
                'member_id' => $formData['member_id'],
                'evaluation' => $formData['evaluation'],
                'comment' => $formData['comment'],
            ]);

            $request->session()->forget('admin_review_form');

            return redirect()->route('admin.reviews.index')
                ->with('success', '商品レビューを登録しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.reviews.create')
                ->with('error', '登録処理中にエラーが発生しました。');
        }
    }

    /**
     * 更新処理
     */
    public function update(Request $request)
    {
        $formData = $request->session()->get('admin_review_form');

        if (!$formData || empty($formData['id'])) {
            return redirect()->route('admin.reviews.index')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            $review = Review::findOrFail($formData['id']);

            $review->update([
                'product_id' => $formData['product_id'],
                'member_id' => $formData['member_id'],
                'evaluation' => $formData['evaluation'],
                'comment' => $formData['comment'],
            ]);

            $request->session()->forget('admin_review_form');

            return redirect()->route('admin.reviews.index')
                ->with('success', '商品レビューを更新しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.reviews.index')
                ->with('error', '更新処理中にエラーが発生しました。');
        }
    }

    /**
     * 詳細画面表示
     */

    public function show($id)
    {
        $review = Review::with(['member', 'product'])->findOrFail($id);
    
        return view('admin.reviews.show', compact('review'));
    }
}