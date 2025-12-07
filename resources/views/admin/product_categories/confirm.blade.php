@extends('admin.layout')

@section('title', $isEdit ? '商品カテゴリ編集確認' : '商品カテゴリ登録確認')

@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品カテゴリ編集確認' : '商品カテゴリ登録確認' }}</h1>

    <div class="confirm-section">
        <div class="confirm-group">
            <label>ID</label>
            <p>{{ $isEdit ? $formData['id'] : '登録後に自動採番' }}</p>
        </div>

        <div class="confirm-group">
            <label>商品大カテゴリ</label>
            <p>{{ $formData['category_name'] }}</p>
        </div>

        <div class="confirm-group">
            <label>商品小カテゴリ</label>
            <ul class="subcategory-list">
                @foreach ($formData['subcategories'] as $subcategory)
                    @if (!empty(trim($subcategory)))
                        <li>{{ $subcategory }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.product_categories.update') : route('admin.product_categories.store') }}" id="confirmForm">
        @csrf
        <div class="button-group">
            <button type="submit" id="submitBtn">{{ $isEdit ? '編集完了' : '登録完了' }}</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.product_categories.back') }}">
        @csrf
        <div class="button-group" style="margin-top: 10px;">
            <button type="submit" class="btn-back">戻る</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<style>
    .confirm-section {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .confirm-group {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .confirm-group:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .confirm-group label {
        font-weight: bold;
        color: #555;
        display: block;
        margin-bottom: 8px;
    }
    .confirm-group p {
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0;
    }
    .subcategory-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .subcategory-list li {
        padding: 8px 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 5px;
    }
    .subcategory-list li:last-child {
        margin-bottom: 0;
    }
    .btn-back {
        background-color: #888;
    }
    .btn-back:hover {
        background-color: #666;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('confirmForm');
    const submitBtn = document.getElementById('submitBtn');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.textContent = '処理中...';
    });
});
</script>
@endsection