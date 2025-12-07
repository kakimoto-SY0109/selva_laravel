<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

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

        // ID検索 AND
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

        // 並べ替え
        $query->orderBy($sortColumn, $sortDirection);

        // 1ページ10件
        $categories = $query->paginate(10)->appends($request->query());

        return view('admin.product_categories.index', compact(
            'categories',
            'id',
            'freeword',
            'sortColumn',
            'sortDirection'
        ));
    }
}