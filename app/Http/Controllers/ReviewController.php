<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($product_id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($product_id);
        $reviews = Review::where('product_id', $product_id)
            ->with('member')
            ->orderByDesc('created_at')
            ->paginate(5);
        
        $avg_rating = $product->average_rating;
        
        return view('reviews.index', compact('product', 'reviews', 'avg_rating'));
    }

    public function create($product_id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($product_id);
        $avg_rating = $product->average_rating;
        
        return view('reviews.create', compact('product', 'avg_rating'));
    }

    public function confirm(StoreReviewRequest $request, $product_id)
    {
        $data = $request->validated();
        $request->session()->put('review_form', $data);
        $request->session()->put('review_product_id', $product_id);

        $product = Product::with(['category', 'subcategory'])->findOrFail($product_id);
        $avg_rating = $product->average_rating;

        return view('reviews.confirm', [
            'formData' => $data,
            'product' => $product,
            'avg_rating' => $avg_rating,
        ]);
    }

    public function back(Request $request, $product_id)
    {
        $data = $request->session()->get('review_form', []);
        return redirect()->route('reviews.create', $product_id)->withInput($data);
    }

    public function store(Request $request, $product_id)
    {
        $data = $request->session()->get('review_form');
        $session_pid = $request->session()->get('review_product_id');

        if (!$data || $session_pid != $product_id) {
            return redirect()->route('reviews.create', $product_id)
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        Review::create([
            'member_id' => Auth::guard('member')->id(),
            'product_id' => $product_id,
            'evaluation' => $data['evaluation'],
            'comment' => $data['comment'],
        ]);

        $request->session()->forget(['review_form', 'review_product_id']);

        return redirect()->route('reviews.complete', $product_id);
    }

    public function complete($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('reviews.complete', compact('product'));
    }
}