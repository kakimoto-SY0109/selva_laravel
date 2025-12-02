@extends('member.layout')
@section('title', '商品レビュー管理')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="review-manage-container">
    <h1>商品レビュー管理</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($reviews as $review)
        <div class="review-box">
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ $review->product->image_1 ? asset('storage/'.$review->product->image_1) : asset('images/no-image.png') }}" alt="商品画像">
                </div>
                <div class="product-details">
                    <div class="product-category">
                        {{ $review->product->category->name ?? '' }} / {{ $review->product->subcategory->name ?? '' }}
                    </div>
                    <div class="product-name">{{ $review->product->name }}</div>
                    <div class="review-rating">
                        商品評価: 
                        <span class="stars">
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
                    <div class="review-comment">
                        @if(mb_strlen($review->comment) > 16)
                            {{ mb_substr($review->comment, 0, 16) }}…
                        @else
                            {{ $review->comment }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('my-reviews.edit', $review->id) }}" class="btn btn-edit">レビュー編集</a>
                <a href="{{ route('my-reviews.delete', $review->id) }}" class="btn btn-delete">レビュー削除</a>
            </div>
        </div>
    @empty
        <p class="no-reviews">レビューはありません。</p>
    @endforelse

    @if ($reviews->lastPage() > 1)
        @php
            $current = $reviews->currentPage();
            $last = $reviews->lastPage();
            $start = max(1, $current - 1);
            $end = min($last, $start + 2);
            if (($end - $start) < 2) {
                $start = max(1, $end - 2);
            }
        @endphp

        <nav class="pagination-wrapper">
            @if ($reviews->onFirstPage() === false)
                <a class="pagination-arrow" href="{{ $reviews->previousPageUrl() }}">‹</a>
            @else
                <span class="pagination-arrow disabled">‹</span>
            @endif

            <ul class="pagination-list">
                @for ($i = $start; $i <= $end; $i++)
                    <li class="pagination-item {{ $i === $current ? 'active' : '' }}">
                        <a class="pagination-link" href="{{ $reviews->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            </ul>

            @if ($current < $last)
                <a class="pagination-arrow" href="{{ $reviews->nextPageUrl() }}">›</a>
            @else
                <span class="pagination-arrow disabled">›</span>
            @endif
        </nav>
    @endif

    <div class="link-group">
        <a href="{{ route('mypage') }}">マイページに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .review-manage-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .review-manage-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
        text-align: center;
    }
    .review-box {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 6px;
        background-color: #f9f9f9;
    }
    .product-info {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    .product-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    .product-details {
        flex: 1;
    }
    .product-category {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    .product-name {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }
    .review-rating {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stars {
        display: inline-flex;
        gap: 2px;
    }
    .star {
        font-size: 18px;
        line-height: 1;
    }
    .star.filled {
        color: #FF9800;
    }
    .star.empty {
        color: #ddd;
    }
    .rating-number {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-left: 4px;
    }
    .review-comment {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .btn {
        flex: 1;
        padding: 10px;
        text-align: center;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .btn-edit {
        background-color: #2196F3;
        color: white;
    }
    .btn-edit:hover {
        background-color: #1976D2;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
    .btn-delete:hover {
        background-color: #d32f2f;
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
    .pagination-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
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
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #eee;
        margin-top: 20px;
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
        .review-manage-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .product-info {
            flex-direction: column;
        }
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection