<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function confirm(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('product_form', $validated);

        $category = ProductCategory::find($validated['product_category_id']);
        $subcategory = ProductSubcategory::find($validated['product_subcategory_id']);

        return view('products.confirm', [
            'formData' => $validated,
            'categoryName' => $category->name ?? '',
            'subcategoryName' => $subcategory->name ?? '',
        ]);
    }

    public function back(Request $request)
    {
        $formData = $request->session()->get('product_form', []);
        return redirect()->route('products.create')->withInput($formData);
    }

    public function store(Request $request)
    {
        $formData = $request->session()->get('product_form');

        if (!$formData) {
            return redirect()->route('products.create')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        try {
            Product::create([
                'member_id' => auth()->id(),
                'name' => $formData['name'],
                'product_category_id' => $formData['product_category_id'],
                'product_subcategory_id' => $formData['product_subcategory_id'],
                'image_1' => $formData['image_1'] ?? null,
                'image_2' => $formData['image_2'] ?? null,
                'image_3' => $formData['image_3'] ?? null,
                'image_4' => $formData['image_4'] ?? null,
                'product_content' => $formData['product_content'],
            ]);

            $request->session()->forget('product_form');

            return redirect()->route('top')->with('success', '商品を登録しました');

        } catch (\Exception $e) {
            Log::error('商品登録エラー: ' . $e->getMessage());
            return redirect()->route('products.create')
                ->withInput()
                ->withErrors(['error' => '登録処理中にエラーが発生しました。']);
        }
    }

    public function getSubcategories($category_id)
    {
        $subcategories = ProductSubcategory::where('product_category_id', $category_id)->get();
        return response()->json($subcategories);
    }

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
}
