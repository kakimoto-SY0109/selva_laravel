@extends('member.layout')
@section('title', '商品レビュー登録確認')
@section('content')
<div class="review-confirm-container">
    <h1>商品レビュー登録確認</h1>
    
    <div class="product-info-section">
        <h2>商品情報</h2>
        <div class="product-display">
            <div class="product-image">
                <img src="{{ $product->image_1 ? asset('storage/'.$product->image_1) : asset('images/no-image.png') }}" alt="商品画像">
            </div>
            <div class="product-details">
                <p class="product-category">{{ $product->category->name ?? '' }} / {{ $product->subcategory->name ?? '' }}</p>
                <p class="product-name">{{ $product->name }}</p>
                <p class="product-rating">
                    総合評価: 
                    @if($avg_rating > 0)
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $avg_rating)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star empty">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="rating-number">{{ $avg_rating }}</span>
                    @else
                        評価なし
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="confirm-section">
        <h2>レビュー内容</h2>
        
        <div class="confirm-item">
            <div class="confirm-label">商品評価</div>
            <div class="confirm-value">{{ $formData['evaluation'] }}</div>
        </div>

        <div class="confirm-item">
            <div class="confirm-label">商品コメント</div>
            <div class="confirm-value comment-text">{{ $formData['comment'] }}</div>
        </div>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ route('reviews.store', $product->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">登録する</button>
        </form>
        
        <form method="POST" action="{{ route('reviews.back', $product->id) }}">
            @csrf
            <button type="submit" class="btn btn-secondary">前に戻る</button>
        </form>
    </div>

    <div class="link-group">
        <a href="{{ route('top') }}">トップに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .review-confirm-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .review-confirm-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .product-info-section {
        margin-bottom: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 6px;
        border: 1px solid #eee;
    }
    .product-info-section h2 {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .product-display {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .product-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }
    .product-details {
        flex: 1;
    }
    .product-category {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }
    .product-name {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }
    .product-rating {
        font-size: 16px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .stars {
        display: inline-flex;
        gap: 2px;
    }
    .star {
        font-size: 20px;
        line-height: 1;
    }
    .star.filled {
        color: #FF9800;
    }
    .star.empty {
        color: #ddd;
    }
    .rating-number {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-left: 4px;
    }
    .confirm-section {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 6px;
        margin-bottom: 30px;
        border: 1px solid #eee;
    }
    .confirm-section h2 {
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .confirm-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }
    .confirm-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .confirm-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        font-weight: bold;
    }
    .confirm-value {
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }
    .comment-text {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 30px;
    }
    .button-group form {
        width: 100%;
    }
    .btn {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }
    .btn-primary:hover {
        background-color: #45a049;
    }
    .btn-secondary {
        background-color: #888;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #666;
    }
    .link-group {
        margin-top: 30px;
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .link-group a {
        color: #4CAF50;
        text-decoration: none;
        font-size: 14px;
    }
    .link-group a:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .review-confirm-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .product-display {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection