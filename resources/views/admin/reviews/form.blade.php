@extends('admin.layout')
@section('title', $isEdit ? '商品レビュー編集' : '商品レビュー登録')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品レビュー編集' : '商品レビュー登録' }}</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="error-messages">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.reviews.confirm') }}" id="review-form">
        @csrf

        @php
            $reviewId = old('id', $review->id ?? null);
            $productId = old('product_id', $review->product_id ?? '');
            $memberId = old('member_id', $review->member_id ?? '');
            $evaluation = old('evaluation', $review->evaluation ?? '');
            $comment = old('comment', $review->comment ?? '');
        @endphp

        @if ($isEdit)
            <input type="hidden" name="id" value="{{ $reviewId }}">
        @endif

        <div class="form-group">
            <label>ID</label>
            <div class="form-value">{{ $isEdit ? $reviewId : '登録後に自動採番' }}</div>
        </div>

        <div class="form-group">
            <label for="product_id">商品</label>
            <select name="product_id" id="product_id">
                <option value="">選択してください</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ (string)$productId === (string)$product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="member_id">会員</label>
            <select name="member_id" id="member_id">
                <option value="">選択してください</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ (string)$memberId === (string)$member->id ? 'selected' : '' }}>
                        {{ $member->name_sei }} {{ $member->name_mei }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="evaluation">商品評価</label>
            <select name="evaluation" id="evaluation">
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ (string)$evaluation === (string)$i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="comment">商品コメント</label>
            <textarea name="comment" id="comment">{{ $comment }}</textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-primary">確認画面へ</button>
            <a href="{{ route('admin.reviews.index') }}" class="btn-secondary">一覧に戻る</a>
        </div>
    </form>
</div>

<style>
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
    font-size: 14px;
}

.form-value {
    padding: 10px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #666;
}

.form-group input[type="text"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group textarea {
    min-height: 150px;
    resize: vertical;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #5dade2;
    box-shadow: 0 0 0 2px rgba(93, 173, 226, 0.1);
}

.error-messages {
    background-color: #fee;
    border: 1px solid #fcc;
    color: #c33;
    padding: 15px 15px 15px 35px;
    margin-bottom: 25px;
    border-radius: 4px;
}

.error-messages ul {
    margin: 0;
    padding: 0;
    list-style-position: inside;
}

.error-messages li {
    margin-bottom: 5px;
}

.button-group {
    margin-top: 40px;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn-primary {
    background-color: #5dade2;
    color: white;
    padding: 12px 50px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #3498db;
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
    padding: 12px 50px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
    text-align: center;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
}

@media (max-width: 768px) {
    .button-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        padding: 12px 20px;
    }
}
</style>

<script>
document.getElementById('review-form').addEventListener('submit', function(e) {
    const submitButton = this.querySelector('button[type="submit"]');
    if (submitButton.disabled) {
        e.preventDefault();
        return false;
    }
    submitButton.disabled = true;
    submitButton.textContent = '処理中...';
});
</script>
@endsection