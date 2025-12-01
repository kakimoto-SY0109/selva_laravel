@extends('member.layout')
@section('title', '商品詳細')
@section('content')
<div class="product-detail-container">
    <h1>商品詳細</h1>
    
    <div class="detail-section">
        <h2>商品画像</h2>
        <div class="image-gallery">
            @if($product->image_1)
                <img src="{{ asset('storage/'.$product->image_1) }}" alt="商品画像1">
            @endif
            @if($product->image_2)
                <img src="{{ asset('storage/'.$product->image_2) }}" alt="商品画像2">
            @endif
            @if($product->image_3)
                <img src="{{ asset('storage/'.$product->image_3) }}" alt="商品画像3">
            @endif
            @if(!$product->image_1 && !$product->image_2 && !$product->image_3)
                <img src="{{ asset('images/no-image.png') }}" alt="画像なし">
            @endif
        </div>
    </div>

    <div class="detail-section">
        <h2>商品カテゴリ</h2>
        <p>{{ $product->category->name ?? 'カテゴリなし' }} / {{ $product->subcategory->name ?? 'サブカテゴリなし' }}</p>
    </div>

    <div class="detail-section">
        <h2>商品名</h2>
        <p>{{ $product->name }}</p>
    </div>

    <div class="detail-section">
        <h2>商品説明</h2>
        <p class="product_content">{!! nl2br(e($product->product_content)) !!}</p>
    </div>

    <div class="detail-section">
        <h2>最終更新日時</h2>
        <p>{{ $product->updated_at->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="link-group">
        <a href="{{ route('products.index', ['page' => $page]) }}">商品一覧に戻る</a>
        <span style="margin: 0 8px;">｜</span>
        <a href="{{ route('top') }}">トップに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .product-detail-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .product-detail-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .detail-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .detail-section:last-of-type {
        border-bottom: none;
    }
    .detail-section h2 {
        font-size: 16px;
        color: #666;
        margin-bottom: 12px;
        font-weight: bold;
    }
    .detail-section p {
        font-size: 15px;
        color: #333;
        line-height: 1.6;
    }
    .detail-section p.updated-time {
        color: #888;
        font-size: 14px;
    }
    .detail-section p.product_content {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .image-gallery {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .image-gallery img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
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
        .product-detail-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .image-gallery img {
            width: 100%;
            max-width: 200px;
        }
    }
</style>
@endsection