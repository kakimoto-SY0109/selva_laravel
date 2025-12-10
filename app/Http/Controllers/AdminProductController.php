<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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

        // ID検索 AND
        if (!empty($id)) {
            $query->where('id', $id);
        }

        // フリーワード検索 OR
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
}