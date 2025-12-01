@extends('member.layout')

@section('title', '商品一覧')

@section('content')
@if (session('success'))
    <div class="flash-message" id="flash-message">
        {{ session('success') }}
    </div>
@endif
<div class="product-create-container">
    <h1>商品一覧</h1>
    
    <form method="get" action="{{ route('products.index') }}">
        <div class="form-group">
            <label for="category_id">商品カテゴリ（大）</label>
            <select name="category_id" id="category_id">
                <option value="">選択してください</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="subcategory-wrapper" style="display:none;">
            <label for="subcategory_id">商品カテゴリ（小）</label>
            <select name="subcategory_id" id="subcategory_id">
                <option value="">選択してください</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keyword">フリーワード</label>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}" placeholder="商品名・商品説明を検索">
        </div>

        <div class="button-group">
            <button type="submit">検索する</button>
        </div>
    </form>

    <div class="link-group">
        <a href="{{ route('top') }}">トップに戻る</a>
        @auth('member')
            <span style="margin: 0 8px;">｜</span>
            <a href="{{ route('products.create', ['from' => 'list']) }}">新規商品登録</a>
        @endauth
    </div>

    @forelse ($products as $p)
        <div class="product-box">
            <div class="image-preview">
                <img src="{{ $p->image_1 ? asset('storage/'.$p->image_1) : asset('images/no-image.png') }}" alt="商品画像">
            </div>
            <div class="product-info">
                <div class="product-category">
                    {{ $p->category->name ?? 'カテゴリなし' }} / {{ $p->subcategory->name ?? 'サブカテゴリなし' }}
                </div>
                <a href="{{ route('products.show', ['id' => $p->id, 'page' => $products->currentPage()]) }}" class="product-name-link">
                    <div class="product-name">{{ $p->name }}</div>
                </a>
            </div>
            <div class="product-actions">
                <a href="{{ route('products.show', ['id' => $p->id, 'page' => $products->currentPage()]) }}" class="detail-button">詳細</a>
            </div>
        </div>
    @empty
        <p>該当する商品はありません。</p>
    @endforelse

    @if ($products->lastPage() > 1)
        @php
            $current = $products->currentPage();
            $last    = $products->lastPage();
            $start   = max(1, $current - 1);
            $end     = min($last, $start + 2);
            if (($end - $start) < 2) {
                $start = max(1, $end - 2);
            }
        @endphp

        <nav class="pagination-wrapper">
            @if ($products->onFirstPage() === false)
                <a class="pagination-arrow"
                   href="{{ $products->url($current - 1) . '&' . http_build_query(request()->except('page')) }}">
                    ‹
                </a>
            @else
                <span class="pagination-arrow disabled">‹</span>
            @endif

            <ul class="pagination-list">
                @for ($i = $start; $i <= $end; $i++)
                    <li class="pagination-item {{ $i === $current ? 'active' : '' }}">
                        <a class="pagination-link"
                           href="{{ $products->url($i) . '&' . http_build_query(request()->except('page')) }}">
                           {{ $i }}
                        </a>
                    </li>
                @endfor
            </ul>

            @if ($current < $last)
                <a class="pagination-arrow"
                   href="{{ $products->url($current + 1) . '&' . http_build_query(request()->except('page')) }}">
                    ›
                </a>
            @else
                <span class="pagination-arrow disabled">›</span>
            @endif
        </nav>
    @endif
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
    input[type="text"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        box-sizing: border-box;
    }
    input[type="text"]:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
    }
    .button-group {
        text-align: center;
        margin-top: 20px;
    }
    .button-group button {
        background-color: #2196F3;
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .button-group button:hover {
        background-color: #1976D2;
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
    .product-box {
        display: flex;
        gap: 12px;
        border: 1px solid #ccc;
        padding: 12px;
        border-radius: 6px;
        background-color: #f9f9f9;
        margin-top: 20px;
        align-items: center;
    }
    .product-box .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .product-category {
        font-size: 12px;
        color: #666;
        margin-bottom: 4px;
    }
    /*修正　product-name*/
    .product-name-link {
        font-weight: bold;
        font-size: 16px;
    }
    .pagination .page-item.active .page-link {
        background-color: #888;
        border-color: #888;
        color: #fff;
        font-weight: bold;
    }
    .product-name-link:hover .product-name {
        color: #2196F3;
        text-decoration: underline;
    }
    .product-name {
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: color 0.2s ease;
    }.product-actions {
        display: flex;
        align-items: center;
    }
    .detail-button {
        padding: 8px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .detail-button:hover {
        background-color: #45a049;
    }
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
        margin-bottom: 20px;
    }
    .pagination-list {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination-item {
        margin: 0;
    }
    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #f5f5f5;
        border-color: #2196F3;
        color: #2196F3;
    }
    .pagination-item.active .pagination-link {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
        font-weight: bold;
        cursor: default;
    }
    .pagination-item.active .pagination-link:hover {
        background-color: #2196F3;
        border-color: #2196F3;
    }
    .pagination-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        transition: all 0.2s ease;
    }
    .pagination-arrow:hover {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
    }
    .pagination-arrow.disabled {
        background-color: #f5f5f5;
        border-color: #ddd;
        color: #ccc;
        cursor: not-allowed;
    }
    .flash-message {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 800px;
        background-color: #888;
        color: #fff;
        padding: 16px 28px;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
        cursor: pointer;
    } 
    @media (max-width: 768px) {
        .product-create-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cat = document.getElementById('category_id');
    const sub = document.getElementById('subcategory_id');
    const wrapper = document.getElementById('subcategory-wrapper');
    const selectedSubId = '{{ $subcategoryId ?? '' }}';

    function loadSubcategories(categoryId, show = true) {
        if (!categoryId) {
            wrapper.style.display = 'none';
            sub.innerHTML = '<option value="">選択してください</option>';
            return;
        }

        fetch('/products/subcategories/' + categoryId)
            .then(res => res.json())
            .then(list => {
                let options = '<option value="">選択してください</option>';
                list.forEach(sc => {
                    const selected = (String(sc.id) === String(selectedSubId)) ? 'selected' : '';
                    options += `<option value="${sc.id}" ${selected}>${sc.name}</option>`;
                });
                sub.innerHTML = options;
                if (show) wrapper.style.display = 'block';
            });
    }

    if (cat.value) {
        loadSubcategories(cat.value, true);
    } else {
        wrapper.style.display = 'none';
    }

    cat.addEventListener('change', function () {
        loadSubcategories(this.value, !!this.value);
    });
});
</script>
<script>
    function hideFlash() {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }
    }

    setTimeout(hideFlash, 10000);

    // クリックでも消える
    document.addEventListener('DOMContentLoaded', function () {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.addEventListener('click', hideFlash);
        }
    });
</script>
@endsection