@extends('member.layout')
@section('title', '商品レビュー登録完了')
@section('content')
<div class="review-complete-container">
    <h1>商品レビュー登録完了</h1>
    
    <div class="complete-message">
        <p>商品レビューの登録が完了しました。</p>
    </div>

    <div class="button-group">
        <a href="{{ route('reviews.index', $product->id) }}" class="btn btn-primary">商品レビュー一覧へ</a>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">商品詳細に戻る</a>
    </div>

    <div class="link-group">
        <a href="{{ route('top') }}">トップに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .review-complete-container {
        max-width: 600px;
        margin: 80px auto;
        padding: 50px 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }
    .review-complete-container h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 30px;
    }
    .complete-message {
        margin-bottom: 40px;
        padding: 30px;
        background-color: #f0f8ff;
        border-radius: 6px;
        border: 2px solid #2196F3;
    }
    .complete-message p {
        font-size: 18px;
        color: #333;
        line-height: 1.8;
        margin: 0;
    }
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .btn {
        display: block;
        padding: 14px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s ease;
        cursor: pointer;
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
        .review-complete-container {
            margin: 60px 16px;
            width: calc(100% - 32px);
            padding: 30px 20px;
        }
    }
</style>
@endsection