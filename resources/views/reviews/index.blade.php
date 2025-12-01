@extends('member.layout')
@section('title', '商品レビュー一覧')
@section('content')
<div class="review-list-container">
    <h1>商品レビュー一覧</h1>
    
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

    <div class="reviews-section">
        <h2>レビュー ({{ $reviews->total() }}件)</h2>
        
        @forelse ($reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <span class="reviewer-name">{{ $review->member->nickname }}</span>
                        <span class="review-date">{{ $review->created_at->format('Y年m月d日 H:i') }}</span>
                    </div>
                    <div class="review-rating">
                        <span class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->evaluation)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star empty">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="rating-number">{{ $review->evaluation }}</span>
                    </div>
                </div>
                <div class="review-comment">
                    {{ $review->comment }}
                </div>
            </div>
        @empty
            <p class="no-reviews">まだレビューはありません。</p>
        @endforelse
    </div>

    @if ($reviews->lastPage() > 1)
        @php
            $current = $reviews->currentPage();
            $last    = $reviews->lastPage();
            $start   = max(1, $current - 1);
            $end     = min($last, $start + 2);
            if (($end - $start) < 2) {
                $start = max(1, $end - 2);
            }
        @endphp

        <nav class="pagination-wrapper">
            @if ($reviews->onFirstPage() === false)
                <a class="pagination-arrow" href="{{ $reviews->previousPageUrl() }}">前へ</a>
            @else
                <span class="pagination-arrow disabled">前へ</span>
            @endif

            <ul class="pagination-list">
                @for ($i = $start; $i <= $end; $i++)
                    <li class="pagination-item {{ $i === $current ? 'active' : '' }}">
                        <a class="pagination-link" href="{{ $reviews->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            </ul>

            @if ($current < $last)
                <a class="pagination-arrow" href="{{ $reviews->nextPageUrl() }}">次へ</a>
            @else
                <span class="pagination-arrow disabled">次へ</span>
            @endif
        </nav>
    @endif

    <div class="link-group">
        <a href="{{ route('products.show', $product->id) }}">商品詳細に戻る</a>
        <span style="margin: 0 8px;">｜</span>
        <a href="{{ route('top') }}">トップに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .review-list-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .review-list-container h1 {
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
    .reviews-section {
        margin-bottom: 30px;
    }
    .reviews-section h2 {
        font-size: 20px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
        padding-bottom: 10px;
        border-bottom: 2px solid #2196F3;
    }
    .review-item {
        padding: 20px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        border-radius: 6px;
        border: 1px solid #eee;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
    .reviewer-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .reviewer-name {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }
    .review-date {
        font-size: 13px;
        color: #888;
    }
    .review-rating {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .rating-stars {
        display: flex;
        gap: 2px;
    }
    .rating-stars .star {
        font-size: 20px;
        line-height: 1;
    }
    .rating-stars .star.filled {
        color: #FF9800;
    }
    .rating-stars .star.empty {
        color: #ddd;
    }
    .review-rating .rating-number {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
    .review-comment {
        font-size: 15px;
        color: #333;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
        padding-left: 0;
    }
    .no-reviews {
        text-align: center;
        padding: 40px;
        font-size: 16px;
        color: #888;
    }
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
        margin-bottom: 20px;
    }
    .pagination-list {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination-item {
        margin: 0;
    }
    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #f5f5f5;
        border-color: #2196F3;
        color: #2196F3;
    }
    .pagination-item.active .pagination-link {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
        font-weight: bold;
        cursor: default;
    }
    .pagination-item.active .pagination-link:hover {
        background-color: #2196F3;
        border-color: #2196F3;
    }
    .pagination-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 16px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .pagination-arrow:hover {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
    }
    .pagination-arrow.disabled {
        background-color: #f5f5f5;
        border-color: #ddd;
        color: #ccc;
        cursor: not-allowed;
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
        .review-list-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .product-display {
            flex-direction: column;
            text-align: center;
        }
        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>
@endsection