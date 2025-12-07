@extends('admin.layout')

@section('title', $isEdit ? '商品カテゴリ編集' : '商品カテゴリ登録')

@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品カテゴリ編集' : '商品カテゴリ登録' }}</h1>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.product_categories.confirm') }}" id="categoryForm">
        @csrf

        @php
            $formData = $formData ?? [];
            $categoryId = $formData['id'] ?? ($category->id ?? null);
            $categoryName = old('category_name', $formData['category_name'] ?? ($category->name ?? ''));
            $subcategories = old('subcategories', $formData['subcategories'] ?? ($category ? $category->subcategories->pluck('name')->toArray() : []));
            if (empty($subcategories)) {
                $subcategories = [''];
            }
        @endphp

        @if ($isEdit)
            <input type="hidden" name="id" value="{{ $categoryId }}">
        @endif

        <div class="form-group">
            <label>ID</label>
            <p class="form-text">{{ $isEdit ? $categoryId : '登録後に自動採番' }}</p>
        </div>

        <div class="form-group">
            <label for="category_name">商品大カテゴリ</label>
            <input type="text" name="category_name" id="category_name" value="{{ $categoryName }}" maxlength="20">
        </div>

        <div class="form-group">
            <label>商品小カテゴリ</label>
            <div id="subcategory-container">
                @foreach ($subcategories as $index => $subcategory)
                    <div class="subcategory-row">
                        <input type="text" name="subcategories[]" value="{{ $subcategory }}" maxlength="20" placeholder="商品小カテゴリを入力">
                        <button type="button" class="btn-remove" onclick="removeSubcategory(this)">削除</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn-add" id="addSubcategory">＋ 商品小カテゴリを追加</button>
            <p class="form-hint">※最大10個まで登録可能</p>
        </div>

        <div class="button-group">
            <button type="submit" id="submitBtn">確認画面へ</button>
        </div>
    </form>

    <div class="link-group">
        <a href="{{ route('admin.product_categories.index') }}">一覧に戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .form-text {
        padding: 12px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #666;
    }
    .subcategory-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        align-items: center;
    }
    .subcategory-row input {
        flex: 1;
    }
    .btn-remove {
        width: auto;
        padding: 8px 15px;
        background-color: #e74c3c;
        font-size: 14px;
    }
    .btn-remove:hover {
        background-color: #c0392b;
    }
    .btn-add {
        width: auto;
        padding: 8px 20px;
        background-color: #3498db;
        font-size: 14px;
        margin-top: 5px;
    }
    .btn-add:hover {
        background-color: #2980b9;
    }
    .form-hint {
        font-size: 12px;
        color: #888;
        margin-top: 8px;
    }
    .error-message {
        background-color: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .error-message ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .link-group {
        margin-top: 20px;
        text-align: center;
    }
    .link-group a {
        color: #5dade2;
        text-decoration: none;
    }
    .link-group a:hover {
        text-decoration: underline;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('subcategory-container');
    const addBtn = document.getElementById('addSubcategory');
    const maxSubcategories = 10;

    // 初期表示時に削除ボタンの表示か非表示
    updateRemoveButtons();

    addBtn.addEventListener('click', function() {
        const rows = container.querySelectorAll('.subcategory-row');
        if (rows.length >= maxSubcategories) {
            alert('商品小カテゴリは10個までです。');
            return;
        }

        const newRow = document.createElement('div');
        newRow.className = 'subcategory-row';
        newRow.innerHTML = `
            <input type="text" name="subcategories[]" value="" maxlength="20" placeholder="商品小カテゴリを入力">
            <button type="button" class="btn-remove" onclick="removeSubcategory(this)">削除</button>
        `;
        container.appendChild(newRow);
        updateRemoveButtons();
    });
});

function removeSubcategory(btn) {
    btn.closest('.subcategory-row').remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const container = document.getElementById('subcategory-container');
    const rows = container.querySelectorAll('.subcategory-row');
    const buttons = container.querySelectorAll('.btn-remove');
    
    buttons.forEach(function(button) {
        if (rows.length <= 1) {
            button.style.display = 'none';
        } else {
            button.style.display = 'inline-block';
        }
    });
}
</script>
@endsection