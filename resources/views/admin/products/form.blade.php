@extends('admin.layout')
@section('title', $isEdit ? '商品編集' : '商品登録')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品編集' : '商品登録' }}</h1>

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

    <form method="POST" action="{{ route('admin.products.confirm') }}" id="product-form">
        @csrf

        @php
            $productId = old('id', $product->id ?? null);
            $productName = old('name', $product->name ?? '');
            $memberId = old('member_id', $product->member_id ?? '');
            $categoryId = old('product_category_id', $product->product_category_id ?? '');
            $subcategoryId = old('product_subcategory_id', $product->product_subcategory_id ?? '');
            $image1 = old('image_1', $product->image_1 ?? '');
            $image2 = old('image_2', $product->image_2 ?? '');
            $image3 = old('image_3', $product->image_3 ?? '');
            $image4 = old('image_4', $product->image_4 ?? '');
            $productContent = old('product_content', $product->product_content ?? '');
        @endphp

        @if ($isEdit)
            <input type="hidden" name="id" value="{{ $productId }}">
        @endif

        <div class="form-group">
            <label>ID</label>
            <div class="form-value">{{ $isEdit ? $productId : '登録後に自動採番' }}</div>
        </div>

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ $productName }}">
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
            <label for="product_category_id">商品カテゴリ大</label>
            <select name="product_category_id" id="product_category_id">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string)$categoryId === (string)$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="subcategory-wrapper" style="{{ $categoryId ? '' : 'display: none;' }}">
            <label for="product_subcategory_id">商品カテゴリ小</label>
            <select name="product_subcategory_id" id="product_subcategory_id">
                <option value="">選択してください</option>
            </select>
        </div>

        @for ($i = 1; $i <= 4; $i++)
            @php
                $imageVar = 'image' . $i;
                $imageValue = $$imageVar;
            @endphp
            <div class="form-group">
                <label>商品写真{{ $i }}</label>
                <div class="image-upload-area">
                    <input type="file" id="imageFile{{ $i }}" class="image-input" data-index="{{ $i }}" accept="image/*" style="display: none;">
                    <label for="imageFile{{ $i }}" class="btn-upload">ファイルを選択</label>
                    <input type="hidden" name="image_{{ $i }}" id="image_{{ $i }}" value="{{ $imageValue }}">
                    <div class="image-preview" id="preview-wrapper-{{ $i }}">
                        @if ($imageValue)
                            <img id="preview_{{ $i }}" src="{{ asset('storage/' . $imageValue) }}" alt="商品写真{{ $i }}">
                        @else
                            <img id="preview_{{ $i }}" src="" alt="商品写真{{ $i }}" style="display: none;">
                        @endif
                    </div>
                </div>
            </div>
        @endfor

        <div class="form-group">
            <label for="product_content">商品説明</label>
            <textarea name="product_content" id="product_content">{{ $productContent }}</textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-primary">確認画面へ</button>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">一覧に戻る</a>
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

.image-upload-area {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-upload {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-align: center;
    transition: background-color 0.3s;
    width: fit-content;
}

.btn-upload:hover {
    background-color: #2980b9;
}

.image-preview img {
    max-width: 200px;
    max-height: 200px;
    border: 1px solid #ddd;
    border-radius: 4px;
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
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('product_category_id');
    const subcategorySelect = document.getElementById('product_subcategory_id');
    const subcategoryWrapper = document.getElementById('subcategory-wrapper');
    const selectedSubcategoryId = '{{ $subcategoryId }}';

    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        
        if (categoryId) {
            loadSubcategories(categoryId, '');
            subcategoryWrapper.style.display = 'block';
        } else {
            subcategorySelect.innerHTML = '<option value="">選択してください</option>';
            subcategoryWrapper.style.display = 'none';
        }
    });

    function loadSubcategories(categoryId, selectedId) {
        fetch('/admin/products/subcategories/' + categoryId)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">選択してください</option>';
                data.forEach(function(subcategory) {
                    const selected = (String(subcategory.id) === String(selectedId)) ? 'selected' : '';
                    options += '<option value="' + subcategory.id + '" ' + selected + '>' + subcategory.name + '</option>';
                });
                subcategorySelect.innerHTML = options;
            });
    }

    if (categorySelect.value) {
        loadSubcategories(categorySelect.value, selectedSubcategoryId);
    }

    // 画像アップロード
    document.querySelectorAll('.image-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const index = this.dataset.index;
            const file = this.files[0];

            if (!file) return;

            // ファイルタイプチェック
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('jpg、jpeg、png、gif形式の画像のみアップロード可能です。');
                this.value = '';
                return;
            }

            // ファイルサイズチェック 10MB
            if (file.size > 10 * 1024 * 1024) {
                alert('画像は10MB以下にしてください。');
                this.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('image', file);

            fetch('{{ route("admin.products.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.path) {
                    document.getElementById('image_' + index).value = data.path;
                    const preview = document.getElementById('preview_' + index);
                    preview.src = data.url;
                    preview.style.display = 'block';
                }
            })
            .catch(error => {
                alert('画像のアップロードに失敗しました。');
            });
        });
    });

    // 二重送信防止
    document.getElementById('product-form').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton.disabled) {
            e.preventDefault();
            return false;
        }
        submitButton.disabled = true;
        submitButton.textContent = '処理中...';
    });
});
</script>
@endsection