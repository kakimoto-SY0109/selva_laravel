@extends('admin.layout')
@section('title', '商品カテゴリ一覧')
@section('content')
<div class="container">
    <h1>商品カテゴリ一覧</h1>

    @if (session('success'))
        <div class="flash-message">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error-messages">{{ session('error') }}</div>
    @endif

    <div style="text-align: right; margin-bottom: 20px;">
        <a href="{{ route('admin.product_categories.create') }}" class="btn-add">商品カテゴリ登録</a>
    </div>

    {{-- 検索フォーム --}}
    <div class="search-box">
        <h2>商品カテゴリ検索</h2>
        <form method="GET" action="{{ route('admin.product_categories.index') }}">
            <div class="search-row">
                <div class="search-item search-id">
                    <label>ID</label>
                    <input type="text" name="id" value="{{ $id }}" placeholder="ID">
                </div>
                
                <div class="search-item search-keyword">
                    <label>フリーワード</label>
                    <input type="text" name="freeword" value="{{ $freeword }}" placeholder="カテゴリ名・サブカテゴリ名">
                </div>
            </div>

            <input type="hidden" name="sort" value="{{ $sortColumn }}">
            <input type="hidden" name="direction" value="{{ $sortDirection }}">

            <div class="search-buttons">
                <button type="submit" class="btn-search">検索する</button>
            </div>
        </form>
    </div>

    {{-- 一覧テーブル --}}
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-id">
                        ID
                        <a href="{{ route('admin.product_categories.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'id', 'direction' => $sortColumn === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="sort-btn">
                            @if($sortColumn === 'id')
                                {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                            @else
                                ▼
                            @endif
                        </a>
                    </th>
                    <th class="col-name">カテゴリ名</th>
                    <th class="col-subcategory">サブカテゴリ</th>
                    <th class="col-date">
                        登録日時
                        <a href="{{ route('admin.product_categories.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'created_at', 'direction' => $sortColumn === 'created_at' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="sort-btn">
                            @if($sortColumn === 'created_at')
                                {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                            @else
                                ▼
                            @endif
                        </a>
                    </th>
                    <th class="col-action">編集</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="col-id">{{ $category->id }}</td>
                        <td class="col-name">
                            <a href="{{ route('admin.product_categories.show', $category->id) }}" class="category-link">
                                {{ $category->name }}
                            </a>
                        </td>
                        <td class="col-subcategory">
                            @if($category->subcategories->count() > 0)
                                {{ $category->subcategories->pluck('name')->implode(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="col-date">{{ $category->created_at ? $category->created_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="col-action">
                            <a href="{{ route('admin.product_categories.show', $category->id) }}" class="btn-detail">詳細</a>
                            <a href="{{ route('admin.product_categories.edit', $category->id) }}" class="btn-edit">編集</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">該当するカテゴリが見つかりませんでした</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ページネーション --}}
    @if($categories->hasPages())
    <div class="pagination-container">
        @if($categories->onFirstPage())
            <span class="pagination-disabled">‹</span>
        @else
            <a href="{{ $categories->previousPageUrl() }}" class="pagination-link">‹</a>
        @endif

        @php
            $currentPage = $categories->currentPage();
            $lastPage = $categories->lastPage();
            $startPage = floor(($currentPage - 1) / 3) * 3 + 1;
            $endPage = min($startPage + 2, $lastPage);
        @endphp

        @for($i = $startPage; $i <= $endPage; $i++)
            @if($i == $currentPage)
                <span class="pagination-current">{{ $i }}</span>
            @else
                <a href="{{ $categories->url($i) }}" class="pagination-link">{{ $i }}</a>
            @endif
        @endfor

        @if($categories->hasMorePages())
            <a href="{{ $categories->nextPageUrl() }}" class="pagination-link">›</a>
        @else
            <span class="pagination-disabled">›</span>
        @endif
    </div>
    @endif

    <div class="back-link">
        <a href="{{ route('admin.top') }}">トップに戻る</a>
    </div>
</div>

<style>
.flash-message {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    text-align: center;
}

.error-messages {
    background-color: #fee;
    border: 1px solid #fcc;
    color: #c33;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    text-align: center;
}

.search-box {
    background: linear-gradient(to bottom, #fafafa, #f5f5f5);
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.search-box h2 {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
    padding-bottom: 10px;
    border-bottom: 2px solid #85d4f5;
}

.search-row {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 25px;
    margin-bottom: 20px;
    align-items: start;
}

.search-item label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
    font-size: 14px;
}

.search-item input[type="text"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.search-item input[type="text"]:focus {
    outline: none;
    border-color: #5dade2;
    box-shadow: 0 0 0 2px rgba(93, 173, 226, 0.1);
}

.search-buttons {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-search {
    background-color: #5dade2;
    color: white;
    padding: 10px 40px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s;
    white-space: nowrap;
}

.btn-search:hover {
    background-color: #3498db;
}

.table-wrapper {
    overflow-x: auto;
    margin-bottom: 25px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}

.data-table th {
    background: linear-gradient(to bottom, #fafafa, #f5f5f5);
    padding: 14px 12px;
    text-align: left;
    font-weight: bold;
    color: #333;
    font-size: 14px;
    border-bottom: 2px solid #e0e0e0;
    white-space: nowrap;
}

.data-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
    color: #333;
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background-color 0.2s;
}

.data-table tbody tr:hover {
    background-color: #f9f9f9;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.col-id {
    width: 80px;
    text-align: center;
}

.col-name {
    width: 150px;
}

.col-subcategory {
    min-width: 250px;
}

.col-date {
    width: 150px;
}

.col-action {
    width: 120px;
    text-align: center;
}

.category-link {
    color: #333;
    text-decoration: none;
}

.category-link:hover {
    color: #5dade2;
    text-decoration: underline;
}

.no-data {
    text-align: center;
    padding: 40px 20px !important;
    color: #999;
    font-size: 14px;
}

.sort-btn {
    text-decoration: none;
    color: #5dade2;
    margin-left: 6px;
    font-size: 11px;
    font-weight: bold;
    display: inline-block;
    transition: color 0.3s;
}

.sort-btn:hover {
    color: #3498db;
}

.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin: 30px 0;
}

.pagination-link {
    padding: 8px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    background-color: white;
    font-size: 18px;
    transition: all 0.3s;
}

.pagination-link:hover {
    background-color: #e8f5fc;
    color: #5dade2;
    border-color: #5dade2;
}

.pagination-current {
    padding: 8px 14px;
    border: 1px solid #5dade2;
    border-radius: 4px;
    background-color: #5dade2;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.pagination-disabled {
    padding: 8px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    color: #ccc;
    background-color: #fafafa;
    font-size: 18px;
}

.back-link {
    text-align: center;
    margin-top: 30px;
}

.back-link a {
    color: #5dade2;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: color 0.3s;
}

.back-link a:hover {
    color: #3498db;
    text-decoration: underline;
}

.btn-add {
    background-color: #5dade2;
    color: white;
    padding: 10px 30px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-add:hover {
    background-color: #3498db;
}

.btn-edit {
    background-color: #5dade2;
    color: white;
    padding: 6px 18px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    margin: 4px;
    transition: background-color 0.3s;
}

.btn-edit:hover {
    background-color: #3498db;
}

.btn-detail {
    background-color: #95a5a6;
    color: white;
    padding: 6px 18px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    transition: background-color 0.3s;
}

.btn-detail:hover {
    background-color: #7f8c8d;
}

@media (max-width: 768px) {
    .search-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .table-wrapper {
        border-radius: 0;
        margin-left: -30px;
        margin-right: -30px;
        width: calc(100% + 60px);
    }
    
    .data-table {
        font-size: 12px;
    }
    
    .data-table th,
    .data-table td {
        padding: 10px 8px;
        white-space: nowrap;
    }
    
    .btn-edit,
    .btn-detail {
        padding: 4px 12px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 1.5em;
    }
    
    .search-box {
        padding: 15px;
    }
    
    .btn-add {
        padding: 8px 20px;
        font-size: 13px;
    }
}
</style>
@endsection