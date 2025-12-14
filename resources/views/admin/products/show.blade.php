@extends('admin.layout')
@section('title', '商品詳細')
@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <div class="detail-box">
        <table class="detail-table">
            <tr>
                <th>ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>会員</th>
                <td>
                    @if($product->member)
                        <a href="{{ route('admin.members.show', $product->member->id) }}" class="member-link">
                            {{ $product->member->name_sei }} {{ $product->member->name_mei }}
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>商品カテゴリ大</th>
                <td>{{ $product->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>商品カテゴリ小</th>
                <td>{{ $product->subcategory->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>商品写真</th>
                <td>
                    <div class="image-gallery">
                        @for ($i = 1; $i <= 4; $i++)
                            @php $image = 'image_' . $i; @endphp
                            @if ($product->$image)
                                <img src="{{ asset('storage/' . $product->$image) }}" alt="商品写真{{ $i }}" class="product-image">
                            @endif
                        @endfor
                        @if (!$product->image_1 && !$product->image_2 && !$product->image_3 && !$product->image_4)
                            -
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th>商品説明</th>
                <td>{!! nl2br(e($product->product_content)) !!}</td>
            </tr>
            <tr>
                <th>登録日時</th>
                <td>{{ $product->created_at ? $product->created_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <th>更新日時</th>
                <td>{{ $product->updated_at ? $product->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-primary">編集</a>
        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">削除</button>
        </form>
        <a href="{{ route('admin.products.index') }}" class="btn-secondary">一覧に戻る</a>
    </div>

    {{-- 総合評価 --}}
        <div class="rating-section">
        <h2>総合評価</h2>
        @if($averageRating > 0)
            <div class="rating-display">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <span class="star filled">★</span>
                        @else
                            <span class="star empty">★</span>
                        @endif
                    @endfor
                </div>
                <span class="rating-number">{{ $averageRating }}</span>
            </div>
        @else
            <p class="no-rating">評価なし</p>
        @endif
    </div>

    {{-- 商品レビュー一覧 --}}
    <div class="review-section">
        <h2>商品レビュー一覧</h2>
        
        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="review-box">
                    <div class="review-header">
                        <span class="review-member">
                            投稿者：
                            <a href="{{ route('admin.members.show', $review->member->id) }}" class="member-link">
                                {{ $review->member->name_sei }} {{ $review->member->name_mei }}
                            </a>
                        </span>
                        <span class="review-date">{{ $review->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="review-rating">
                        評価：
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->evaluation)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star empty">★</span>
                                @endif
                            @endfor
                        </span>
                    </div>
                    <div class="review-content">
                        {{ Str::limit($review->comment, 100) }}
                    </div>
                    <div class="review-action">
                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn-review-detail">レビュー詳細</a>
                    </div>
                </div>
            @endforeach

            {{-- ページネーション --}}
            @if($reviews->hasPages())
            <div class="pagination-container">
                @if($reviews->onFirstPage())
                    <span class="pagination-disabled">‹</span>
                @else
                    <a href="{{ $reviews->previousPageUrl() }}" class="pagination-link">‹</a>
                @endif

                @php
                    $currentPage = $reviews->currentPage();
                    $lastPage = $reviews->lastPage();
                    
                    if ($currentPage < $lastPage) {
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $startPage + 2);
                    } else {
                        $endPage = $lastPage;
                        $startPage = max(1, $endPage - 2);
                    }
                @endphp

                @for($i = $startPage; $i <= $endPage; $i++)
                    @if($i == $currentPage)
                        <span class="pagination-current">{{ $i }}</span>
                    @else
                        <a href="{{ $reviews->url($i) }}" class="pagination-link">{{ $i }}</a>
                    @endif
                @endfor

                @if($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" class="pagination-link">›</a>
                @else
                    <span class="pagination-disabled">›</span>
                @endif
            </div>
            @endif
        @else
            <p class="no-review">レビューはありません</p>
        @endif
    </div>
</div>

<style>
.detail-box {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 30px;
}
.detail-table {
    width: 100%;
    border-collapse: collapse;
}
.detail-table th,
.detail-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
    vertical-align: top;
}
.detail-table th {
    width: 200px;
    font-weight: bold;
    color: #555;
    background-color: #fafafa;
}
.detail-table td {
    color: #333;
}
.detail-table tr:last-child th,
.detail-table tr:last-child td {
    border-bottom: none;
}
.member-link {
    color: #5dade2;
    text-decoration: none;
}
.member-link:hover {
    text-decoration: underline;
}
.image-gallery {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.product-image {
    max-width: 150px;
    max-height: 150px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.button-group {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 40px;
}
.btn-primary,
.btn-danger,
.btn-secondary {
    padding: 12px 50px;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}
.btn-primary {
    background-color: #5dade2;
    color: white;
}
.btn-primary:hover {
    background-color: #3498db;
}
.btn-danger {
    background-color: #e74c3c;
    color: white;
}
.btn-danger:hover {
    background-color: #c0392b;
}
.btn-secondary {
    background-color: #95a5a6;
    color: white;
}
.btn-secondary:hover {
    background-color: #7f8c8d;
}
.review-section {
    margin-top: 40px;
}
.review-section h2 {
    font-size: 20px;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #5dade2;
}
.review-box {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.review-member {
    font-weight: bold;
}
.review-date {
    color: #888;
    font-size: 13px;
}
.review-rating {
    margin-bottom: 10px;
}
.stars {
    display: inline-flex;
    gap: 2px;
}
.star {
    font-size: 18px;
}
.star.filled {
    color: #f39c12;
}
.star.empty {
    color: #ddd;
}
.review-content {
    color: #333;
    line-height: 1.6;
    margin-bottom: 15px;
}
.review-action {
    text-align: right;
}
.btn-review-detail {
    display: inline-block;
    padding: 8px 20px;
    background-color: #5dade2;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 13px;
    transition: background-color 0.3s;
}
.btn-review-detail:hover {
    background-color: #3498db;
}
.no-review {
    text-align: center;
    color: #888;
    padding: 40px;
    background-color: #f9f9f9;
    border-radius: 8px;
}
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin: 30px 0;
}
.pagination-link {
    padding: 8px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    background-color: white;
    font-size: 18px;
    transition: all 0.3s;
}
.pagination-link:hover {
    background-color: #e8f5fc;
    color: #5dade2;
    border-color: #5dade2;
}
.pagination-current {
    padding: 8px 14px;
    border: 1px solid #5dade2;
    border-radius: 4px;
    background-color: #5dade2;
    color: white;
    font-weight: bold;
    font-size: 14px;
}
.pagination-disabled {
    padding: 8px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    color: #ccc;
    background-color: #fafafa;
    font-size: 18px;
}
.rating-section {
    margin-top: 40px;
    margin-bottom: 20px;
}
.rating-section h2 {
    font-size: 20px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #5dade2;
}
.rating-display {
    display: flex;
    align-items: center;
    gap: 15px;
}
.rating-number {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}
.no-rating {
    color: #888;
    font-size: 14px;
}
@media (max-width: 768px) {
    .detail-box {
        padding: 20px;
    }   
    .detail-table th {
        width: 120px;
        font-size: 13px;
    }    
    .detail-table td {
        font-size: 13px;
    }   
    .button-group {
        flex-direction: column;
    }   
    .btn-primary,
    .btn-danger,
    .btn-secondary {
        width: 100%;
    }   
    .review-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }   
    .product-image {
        max-width: 100px;
        max-height: 100px;
    }
}
@media (max-width: 480px) {
    .detail-table {
        font-size: 12px;
    }   
    .detail-table th,
    .detail-table td {
        padding: 10px;
    }   
    .detail-table th {
        width: 100px;
    }
}
</style>
@endsection