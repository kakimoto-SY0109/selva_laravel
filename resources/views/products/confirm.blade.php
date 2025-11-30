@extends('member.layout')

@section('title', '商品登録確認')

@section('content')
<div class="product-create-container">
    <h1>商品登録確認</h1>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <div class="form-group">
            <label>商品名</label>
            <p class="confirm-value">{{ $formData['name'] }}</p>
        </div>

        <div class="form-group">
            <label>カテゴリ（大）</label>
            <p class="confirm-value">{{ $categoryName }}</p>
        </div>

        <div class="form-group">
            <label>カテゴリ（小）</label>
            <p class="confirm-value">{{ $subcategoryName }}</p>
        </div>

        <div class="form-group">
            <label>商品説明</label>
            <p class="confirm-value" style="white-space: pre-wrap;">{{ $formData['product_content'] }}</p>
        </div>

        @for ($i = 1; $i <= 4; $i++)
            @if (!empty($formData['image_'.$i]))
                <div class="form-group">
                    <label>商品写真{{ $i }}</label>
                    <div class="image-preview">
                        <img src="{{ asset('storage/' . $formData['image_'.$i]) }}" alt="画像{{ $i }}" style="max-width: 200px;">
                    </div>
                </div>
            @endif
        @endfor

        <div class="button-group">
            <button type="submit" id="submit-btn">商品を登録する</button>
        </div>
    </form>

    <form method="POST" action="{{ route('products.back') }}">
        @csrf
        <div class="link-group" style="margin-top: 16px;">
            <button type="submit" class="upload-button">戻る</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<style>
    .product-create-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
    }
    .confirm-value {
        color: #555;
        font-size: 15px;
        padding: 8px 12px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .image-preview img {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .button-group {
        text-align: center;
        margin-top: 30px;
    }
    .button-group button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 24px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }
    .button-group button:hover {
        background-color: #45a049;
    }
    .upload-button {
        display: inline-block;
        background-color: #888;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
        transition: background-color 0.2s ease;
        border: none;
    }
    .upload-button:hover {
        background-color: #666;
    }
    .link-group {
        text-align: center;
    }
    textarea {
        width: 100%;
        box-sizing: border-box;
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
</style>
@endsection