@extends('member.layout')
@section('title', '商品レビュー登録')
@section('content')
<div class="review-form-container">
    <h1>商品レビュー登録</h1>
    
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

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.confirm', $product->id) }}">
        @csrf
        
        <div class="form-group">
            <label for="evaluation">商品評価</label>
            <select name="evaluation" id="evaluation" class="form-control">
                <option value="">選択してください</option>
                <option value="1" {{ old('evaluation') == '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('evaluation') == '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('evaluation') == '3' ? 'selected' : '' }}>3</option>
                <option value="4" {{ old('evaluation') == '4' ? 'selected' : '' }}>4</option>
                <option value="5" {{ old('evaluation') == '5' ? 'selected' : '' }}>5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comment">商品コメント</label>
            <textarea name="comment" id="comment" rows="8" class="form-control" placeholder="500文字以内で入力してください">{{ old('comment') }}</textarea>
            <p class="char-count">残り: <span id="remaining">500</span>文字</p>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">商品レビュー登録確認</button>
        </div>
    </form>

    <div class="link-group">
        <a href="{{ route('products.show', $product->id) }}">商品詳細に戻る</a>
        <span style="margin: 0 8px;">｜</span>
        <a href="{{ route('top') }}">トップに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .review-form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .review-form-container h1 {
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
    .error-message {
        background-color: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }
    .error-message div {
        margin-bottom: 8px;
    }
    .error-message div:last-child {
        margin-bottom: 0;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: bold;
        font-size: 15px;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        box-sizing: border-box;
    }
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D'12'%20height%3D'8'%20viewBox%3D'0%200%2012%208'%20xmlns%3D'http%3A//www.w3.org/2000/svg'%3E%3Cpath%20d%3D'M1%201l5%205%205-5'%20stroke%3D'%23666'%20stroke-width%3D'2'%20fill%3D'none'%20fill-rule%3D'evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px 8px;
        padding-right: 35px;
    }
    textarea.form-control {
        resize: vertical;
        font-family: sans-serif;
    }
    .form-control:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
    }
    .char-count {
        font-size: 13px;
        color: #666;
        text-align: right;
        margin-top: 5px;
    }
    .button-group {
        text-align: center;
        margin-top: 30px;
    }
    .btn {
        padding: 14px 50px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .btn-primary {
        background-color: #2196F3;
        color: white;
    }
    .btn-primary:hover {
        background-color: #1976D2;
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
        .review-form-container {
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('comment');
    const remaining = document.getElementById('remaining');
    const max = 500;

    textarea.addEventListener('input', function() {
        const len = this.value.length;
        const rem = max - len;
        remaining.textContent = rem;
        remaining.style.color = rem < 0 ? '#f44336' : '#666';
    });
});
</script>
@endsection