@extends('admin.layout')
@section('title', '商品レビュー詳細')
@section('content')
<div class="container">
    <h1>商品レビュー詳細</h1>

    {{-- 商品情報 --}}
    <div class="product-info-box">
        <h2>商品情報</h2>
        <table class="info-table">
            <tr>
                <th>商品ID</th>
                <td>{{ $review->product->id }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>
                    <a href="{{ route('admin.products.show', $review->product->id) }}" class="link">
                        {{ $review->product->name }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>商品画像</th>
                <td>
                    <div class="image-gallery">
                        @php
                            $hasImage = false;
                        @endphp
                        @for ($i = 1; $i <= 4; $i++)
                            @php $image = 'image_' . $i; @endphp
                            @if ($review->product->$image)
                                @php $hasImage = true; @endphp
                                <img src="{{ asset('storage/' . $review->product->$image) }}" alt="商品写真{{ $i }}" class="product-image">
                            @endif
                        @endfor
                        @if (!$hasImage)
                            <p>画像なし</p>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th>総合評価</th>
                <td>
                    @if($averageRating > 0)
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $averageRating)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star empty">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="rating-number">{{ $averageRating }}</span>
                    @else
                        <span class="no-rating">評価なし</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- レビュー詳細 --}}
    <div class="detail-box">
        <h2>レビュー詳細</h2>
        <table class="detail-table">
            <tr>
                <th>ID</th>
                <td>{{ $review->id }}</td>
            </tr>
            <tr>
                <th>投稿者</th>
                <td>
                    <a href="{{ route('admin.members.show', $review->member->id) }}" class="link">
                        {{ $review->member->name_sei }} {{ $review->member->name_mei }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>評価</th>
                <td>
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->evaluation)
                                <span class="star filled">★</span>
                            @else
                                <span class="star empty">★</span>
                            @endif
                        @endfor
                    </span>
                    {{ $review->evaluation }}
                </td>
            </tr>
            <tr>
                <th>商品コメント</th>
                <td>{!! nl2br(e($review->comment)) !!}</td>
            </tr>
            <tr>
                <th>登録日時</th>
                <td>{{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <th>更新日時</th>
                <td>{{ $review->updated_at ? $review->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn-primary">編集</a>
        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">削除</button>
        </form>
        <a href="{{ route('admin.reviews.index') }}" class="btn-secondary">一覧に戻る</a>
    </div>
</div>

<style>
.product-info-box {
    background-color: #e8f4fc;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #5dade2;
    margin-bottom: 30px;
}
.product-info-box h2 {
    font-size: 16px;
    margin-bottom: 15px;
    color: #333;
    padding-bottom: 10px;
    border-bottom: 2px solid #5dade2;
}
.info-table {
    width: 100%;
    border-collapse: collapse;
}
.info-table th,
.info-table td {
    padding: 10px 15px;
    text-align: left;
    border-bottom: 1px solid #b8daef;
    vertical-align: top;
}
.info-table th {
    width: 150px;
    font-weight: bold;
    color: #555;
    background-color: #d9ecf7;
}
.info-table tr:last-child th,
.info-table tr:last-child td {
    border-bottom: none;
}
.image-gallery {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.product-image {
    max-width: 100px;
    max-height: 100px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.detail-box {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 30px;
}
.detail-box h2 {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
    padding-bottom: 10px;
    border-bottom: 2px solid #85d4f5;
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
.link {
    color: #5dade2;
    text-decoration: none;
}
.link:hover {
    text-decoration: underline;
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
.rating-number {
    margin-left: 10px;
    font-weight: bold;
}
.no-rating {
    color: #888;
}
.button-group {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
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
@media (max-width: 768px) {
    .product-info-box,
    .detail-box {
        padding: 20px;
    }   
    .info-table th,
    .detail-table th {
        width: 120px;
        font-size: 13px;
    }   
    .info-table td,
    .detail-table td {
        font-size: 13px;
    }   
    .product-image {
        max-width: 80px;
        max-height: 80px;
    }    
    .button-group {
        flex-direction: column;
    }  
    .btn-primary,
    .btn-danger,
    .btn-secondary {
        width: 100%;
    }
}
</style>
@endsection