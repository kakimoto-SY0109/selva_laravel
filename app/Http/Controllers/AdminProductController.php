<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\Member;
use App\Http\Requests\AdminProductRequest;

class AdminProductController extends Controller
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

        $query = Product::query()
            ->with(['category', 'subcategory', 'member']);

        if (!empty($id)) {
            $query->where('id', $id);
        }

        if (!empty($freeword)) {
            $query->where(function ($q) use ($freeword) {
                $q->where('name', 'like', "%{$freeword}%")
                  ->orWhere('product_content', 'like', "%{$freeword}%");
            });
        }

        $query->orderBy($sortColumn, $sortDirection);
        $products = $query->paginate(10)->appends($request->query());

        return view('admin.products.index', compact(
            'products',
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
        $members = Member::all();
        $categories = ProductCategory::all();

        return view('admin.products.form', [
            'product' => null,
            'isEdit' => false,
            'members' => $members,
            'categories' => $categories,
        ]);
    }

    /**
     * 編集フォーム表示
     */
    public function edit($id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);
        $members = Member::all();
        $categories = ProductCategory::all();

        return view('admin.products.form', [
            'product' => $product,
            'isEdit' => true,
            'members' => $members,
            'categories' => $categories,
        ]);
    }

    /**
     * 確認画面表示
     */
    public function confirm(AdminProductRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('admin_product_form', $validated);

        $isEdit = !empty($validated['id']);

        $member = Member::find($validated['member_id']);
        $category = ProductCategory::find($validated['product_category_id']);
        $subcategory = ProductSubcategory::find($validated['product_subcategory_id']);

        return view('admin.products.confirm', [
            'formData' => $validated,
            'isEdit' => $isEdit,
            'memberName' => $member ? $member->name_sei . ' ' . $member->name_mei : '',
            'categoryName' => $category->name ?? '',
            'subcategoryName' => $subcategory->name ?? '',
        ]);
    }

    /**
     * フォームに戻る
     */
    public function back(Request $request)
    {
        $formData = $request->session()->get('admin_product_form', []);
        $isEdit = !empty($formData['id']);

        if ($isEdit) {
            return redirect()->route('admin.products.edit', $formData['id'])
                ->withInput($formData);
        } else {
            return redirect()->route('admin.products.create')
                ->withInput($formData);
        }
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $formData = $request->session()->get('admin_product_form');

        if (!$formData) {
            return redirect()->route('admin.products.create')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            Product::create([
                'member_id' => $formData['member_id'],
                'product_category_id' => $formData['product_category_id'],
                'product_subcategory_id' => $formData['product_subcategory_id'],
                'name' => $formData['name'],
                'image_1' => $formData['image_1'] ?? null,
                'image_2' => $formData['image_2'] ?? null,
                'image_3' => $formData['image_3'] ?? null,
                'image_4' => $formData['image_4'] ?? null,
                'product_content' => $formData['product_content'],
            ]);

            $request->session()->forget('admin_product_form');

            return redirect()->route('admin.products.index')
                ->with('success', '商品を登録しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.products.create')
                ->with('error', '登録処理中にエラーが発生しました。');
        }
    }

    /**
     * 更新処理
     */
    public function update(Request $request)
    {
        $formData = $request->session()->get('admin_product_form');

        if (!$formData || empty($formData['id'])) {
            return redirect()->route('admin.products.index')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            $product = Product::findOrFail($formData['id']);

            $product->update([
                'member_id' => $formData['member_id'],
                'product_category_id' => $formData['product_category_id'],
                'product_subcategory_id' => $formData['product_subcategory_id'],
                'name' => $formData['name'],
                'image_1' => $formData['image_1'] ?? null,
                'image_2' => $formData['image_2'] ?? null,
                'image_3' => $formData['image_3'] ?? null,
                'image_4' => $formData['image_4'] ?? null,
                'product_content' => $formData['product_content'],
            ]);

            $request->session()->forget('admin_product_form');

            return redirect()->route('admin.products.index')
                ->with('success', '商品を更新しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', '更新処理中にエラーが発生しました。');
        }
    }

    /**
     * サブカテゴリ取得
     */
    public function getSubcategories($categoryId)
    {
        $subcategories = ProductSubcategory::where('product_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    /**
     * 画像アップロード
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $path = $request->file('image')->store('products', 'public');

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    /**
     * 詳細画面表示
     */
    public function show(Request $request, $id)
    {
        $product = Product::with(['category', 'subcategory', 'member'])->findOrFail($id);

        // 総合評価
        $averageRating = $product->reviews()->avg('evaluation');
        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        // レビュー一覧 1ページ3件
        $reviews = $product->reviews()
        ->with('member')
        ->orderByDesc('id')
        ->paginate(3)
        ->appends($request->query());

        return view('admin.products.show', compact('product', 'reviews', 'averageRating'));
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $product = Product::findOrFail($id);

                $product->reviews()->delete();
            
                $product->delete();
            });

            return redirect()->route('admin.products.index')
                ->with('success', '商品を削除しました。');

        }catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', '削除処理中にエラーが発生しました。');
        }
    }

    /**
     * レビュー詳細画面表示
     */
    public function showReview($id)
    {
        $review = \App\Models\Review::with(['member', 'product'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }
}