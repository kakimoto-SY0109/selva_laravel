@extends('member.layout')

@section('title', '商品登録')

@section('content')
<div class="product-create-container">
    <h1>商品登録</h1>

    @if ($errors->any())
        <div class="error-message">
            <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.confirm') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="category">商品カテゴリ（大） </label>
            <select name="product_category_id" id="category">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="subcategory-wrapper" style="display: none;">
            <label for="subcategory">商品カテゴリ（小） </label>
            <select name="product_subcategory_id" id="subcategory">
                <option value="">選択してください</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_content">商品説明 </label>
            <textarea id="product_content" name="product_content">{{ old('product_content') }}</textarea>
        </div>

        @php 
        /*
        @for ($i = 1; $i <= 4; $i++)
            <div class="form-group">
                <label>商品写真{{ $i }}</label>
                <div class="image-upload-area">
                <input type="file" name="image_input_{{ $i }}" class="image-input" data-index="{{ $i }}">
                <input type="hidden" name="image_{{ $i }}" id="image_{{ $i }}" value="{{ old('image_'.$i) }}">
                <div class="image-preview">
                    @if (old('image_'.$i))
                        <img id="preview_{{ $i }}" src="{{ asset('storage/' . old('image_'.$i)) }}" alt="商品写真{{ $i }}">
                    @else
                        <img id="preview_{{ $i }}" src="" alt="商品写真{{ $i }}" style="display: none;">
                    @endif
                </div>
            </div>
        @endfor
        */
        @endphp

        @for ($i = 1; $i <= 4; $i++)
        <div class="form-group">
            <label>商品写真{{ $i }}</label>
            <div class="image-upload-area">
            <input type="file" id="imageFile{{ $i }}" class="image-input" data-index="{{ $i }}" accept="image/*" style="display: none;">
            <label for="imageFile{{ $i }}" class="upload-button">ファイルを選択</label>
            <input type="hidden" name="image_{{ $i }}" id="image_{{ $i }}" value="{{ old('image_'.$i) }}">
            <div class="image-preview">
                <img id="preview_{{ $i }}" src="{{ old('image_'.$i) ? asset('storage/' . old('image_'.$i)) : '' }}">
            </div>
        </div>
    </div>
@endfor  
        <div class="button-group">
            <button type="submit" id="submit-btn">確認画面へ</button>
        </div>
        <div class="link-group">
            <a href="{{ route('top') }}">トップに戻る</a>
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
    select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fff;
        font-size: 15px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D'12'%20height%3D'8'%20viewBox%3D'0%200%2012%208'%20xmlns%3D'http%3A//www.w3.org/2000/svg'%3E%3Cpath%20d%3D'M1%201l5%205%205-5'%20stroke%3D'%23666'%20stroke-width%3D'2'%20fill%3D'none'%20fill-rule%3D'evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px 8px;
    }
    select:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
    }
    textarea {
        width: 100%;
        padding: 10px 12px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fff;
        resize: vertical;
        min-height: 150px;
        font-family: sans-serif;
    }
    textarea:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
    }
    .link-group {
        margin-top: 20px;
        text-align: center;
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
        .product-create-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
    }
    .upload-button {
        display: inline-block;
        background-color: #2196F3;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
        transition: background-color 0.2s ease;
    }
    .upload-button:hover {
        background-color: #1976D2;
    }
    textarea {
        width: 100%;
        box-sizing: border-box;
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    $('#category').on('change', function () {
        const categoryId = $(this).val();
        const $subcategoryWrapper = $('#subcategory-wrapper');
        const $subcategory = $('#subcategory');

        $subcategory.empty().append('<option value="">選択してください</option>');

        if (categoryId) {
            $.get(`/products/subcategories/${categoryId}`, function (data) {
                data.forEach(function (subcategory) {
                    $subcategory.append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
                });
                $subcategoryWrapper.show();
            });
        } else {
            // 大カテゴリ見選択　非表示
            $subcategoryWrapper.hide();
        }
    });

    $('.image-input').on('change', function () {
        const index = $(this).data('index');
        const file = this.files[0];
        const formData = new FormData();
        formData.append('image', file);
        $.ajax({
            url: '{{ route("products.upload.image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                $(`#image_${index}`).val(res.path);
                $(`#preview_${index}`).attr('src', res.url).show();
            },
            error: function (xhr) {
                alert('画像のアップロードに失敗しました: ' + xhr.responseJSON.message);
                $(`#image_${index}`).val('');
                $(`#preview_${index}`).hide();
            }
        });
    });
    // 確認画面から戻った際にカテゴリ（小）取得
    const oldCategoryId = $('#category').val();
    const oldSubcategoryId = '{{ old('product_subcategory_id') }}';

    if (oldCategoryId && oldSubcategoryId) {
        const $subcategory = $('#subcategory');
        const $subcategoryWrapper = $('#subcategory-wrapper');
        $.get(`/products/subcategories/${oldCategoryId}`, function (data) {
            $subcategory.empty().append('<option value="">選択してください</option>');
            data.forEach(function (subcategory) {
                const selected = subcategory.id == oldSubcategoryId ? 'selected' : '';
                $subcategory.append(`<option value="${subcategory.id}" ${selected}>${subcategory.name}</option>`);
            });
            $subcategoryWrapper.show();
        });
    }
});
</script>
@endsection