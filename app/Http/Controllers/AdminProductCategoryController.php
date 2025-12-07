<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Http\Requests\AdminProductCategoryRequest;

class AdminProductCategoryController extends Controller
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

        $query = ProductCategory::query()
            ->with('subcategories');

        if (!empty($id)) {
            $query->where('id', $id);
        }

        if (!empty($freeword)) {
            $query->where(function ($q) use ($freeword) {
                $q->where('name', 'like', "%{$freeword}%")
                  ->orWhereHas('subcategories', function ($subQuery) use ($freeword) {
                      $subQuery->where('name', 'like', "%{$freeword}%");
                  });
            });
        }

        $query->orderBy($sortColumn, $sortDirection);
        $categories = $query->paginate(10)->appends($request->query());

        return view('admin.product_categories.index', compact(
            'categories',
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
        return view('admin.product_categories.form', [
            'category' => null,
            'isEdit' => false,
        ]);
    }

    /**
     * 編集フォーム表示
     */
    public function edit($id)
    {
        $category = ProductCategory::with('subcategories')->findOrFail($id);
        
        return view('admin.product_categories.form', [
            'category' => $category,
            'isEdit' => true,
        ]);
    }

    /**
     * 確認画面表示
     */
    public function confirm(AdminProductCategoryRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('product_category_form', $validated);

        $isEdit = !empty($validated['id']);

        return view('admin.product_categories.confirm', [
            'formData' => $validated,
            'isEdit' => $isEdit,
        ]);
    }

    /**
     * フォームに戻る
     */
    public function back(Request $request)
    {
        $formData = $request->session()->get('product_category_form', []);
        $isEdit = !empty($formData['id']);

        return view('admin.product_categories.form', [
            'category' => null,
            'isEdit' => $isEdit,
            'formData' => $formData,
        ]);
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $formData = $request->session()->get('product_category_form');

        if (!$formData) {
            return redirect()->route('admin.product_categories.create')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            DB::transaction(function () use ($formData) {
                // カテゴリ登録
                $category = ProductCategory::create([
                    'name' => $formData['category_name'],
                ]);

                $subcategories = array_filter($formData['subcategories'], fn($name) => !empty(trim($name)));
                foreach ($subcategories as $subcategoryName) {
                    ProductSubcategory::create([
                        'product_category_id' => $category->id,
                        'name' => $subcategoryName,
                    ]);
                }
            });

            $request->session()->forget('product_category_form');

            return redirect()->route('admin.product_categories.index')
                ->with('success', '商品カテゴリを登録しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.product_categories.create')
                ->with('error', '登録処理中にエラーが発生しました。');
        }
    }

    /**
     * 更新処理
     */
    public function update(Request $request)
    {
        $formData = $request->session()->get('product_category_form');

        if (!$formData || empty($formData['id'])) {
            return redirect()->route('admin.product_categories.index')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            DB::transaction(function () use ($formData) {
                $category = ProductCategory::findOrFail($formData['id']);
                
                // カテゴリ更新
                $category->update([
                    'name' => $formData['category_name'],
                ]);

                ProductSubcategory::where('product_category_id', $category->id)->forceDelete();

                $subcategories = array_filter($formData['subcategories'], fn($name) => !empty(trim($name)));
                foreach ($subcategories as $subcategoryName) {
                    ProductSubcategory::create([
                        'product_category_id' => $category->id,
                        'name' => $subcategoryName,
                    ]);
                }
            });

            $request->session()->forget('product_category_form');

            return redirect()->route('admin.product_categories.index')
                ->with('success', '商品カテゴリを更新しました。');

        } catch (\Exception $e) {
            return redirect()->route('admin.product_categories.index')
                ->with('error', '更新処理中にエラーが発生しました。');
        }
    }

    /**
     * 詳細画面表示
    */
    public function show($id)
    {
        $category = ProductCategory::with('subcategories')->findOrFail($id);
        return view('admin.product_categories.show', compact('category'));
    }

    /**
     * 削除処理
    */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $category = ProductCategory::findOrFail($id);
                // サブカテゴリ
                ProductSubcategory::where('product_category_id', $id)->delete();
                // カテゴリ
                $category->delete();
            });

            return redirect()->route('admin.product_categories.index')
                ->with('success', '商品カテゴリを削除しました。');
        } catch (\Exception $e) {
            return redirect()->route('admin.product_categories.index')
                ->with('error', '削除処理中にエラーが発生しました。');
            }
    }
}