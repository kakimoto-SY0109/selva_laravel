@extends('admin.layout')

@section('title', '商品カテゴリ一覧')

@section('content')
<div class="admin-container">
    <h1>商品カテゴリ一覧</h1>

    @if (session('success'))
    <div class="flash-message">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
    @endif

    {{-- 検索フォーム --}}
    <form method="get" action="{{ route('admin.product_categories.index') }}" class="search-form">
        <div class="form-row">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" name="id" id="id" value="{{ $id }}" placeholder="IDで検索">
            </div>

            <div class="form-group">
                <label for="freeword">フリーワード</label>
                <input type="text" name="freeword" id="freeword" value="{{ $freeword }}" placeholder="カテゴリ名・サブカテゴリ名">
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">検索する</button>
        </div>
    </form>

    <div class="link-group">
        <a href="{{ route('admin.product_categories.create') }}">商品カテゴリ登録</a>
        <span class="separator">｜</span>
        <a href="{{ route('admin.top') }}">トップに戻る</a>
    </div>

    {{-- 一覧テーブル --}}
    <table class="data-table">
        <thead>
            <tr>
                <th class="sortable">
                    ID
                    <a href="{{ route('admin.product_categories.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => ($sortColumn === 'id' && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        @if($sortColumn === 'id')
                            @if($sortDirection === 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @else
                            ▼
                        @endif
                    </a>
                </th>
                <th>カテゴリ名</th>
                <th>サブカテゴリ</th>
                <th class="sortable">
                    登録日時
                    <a href="{{ route('admin.product_categories.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => ($sortColumn === 'created_at' && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        @if($sortColumn === 'created_at')
                            @if($sortDirection === 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @else
                            ▼
                        @endif
                    </a>
                </th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if($category->subcategories->count() > 0)
                            {{ $category->subcategories->pluck('name')->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $category->created_at ? $category->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.product_categories.edit', $category->id) }}" class="btn-edit">編集</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">該当するカテゴリはありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ページネーション --}}
    @if ($categories->lastPage() > 1)
        @php
            $current = $categories->currentPage();
            $last = $categories->lastPage();
            $start = max(1, $current - 1);
            $end = min($last, $start + 2);
            if (($end - $start) < 2) {
                $start = max(1, $end - 2);
            }
        @endphp

        <nav class="pagination-wrapper">
            {{-- 前へボタン --}}
            @if ($current > 1)
                <a class="pagination-arrow" href="{{ $categories->url($current - 1) }}">
                    ‹
                </a>
            @endif

            <ul class="pagination-list">
                @for ($i = $start; $i <= $end; $i++)
                    <li class="pagination-item {{ $i === $current ? 'active' : '' }}">
                        <a class="pagination-link" href="{{ $categories->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor
            </ul>

            {{-- 次へボタン --}}
            @if ($current < $last)
                <a class="pagination-arrow" href="{{ $categories->url($current + 1) }}">
                    ›
                </a>
            @endif
        </nav>
    @endif
</div>
@endsection

@section('scripts')
<style>
    .admin-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .admin-container h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    .search-form {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .form-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .form-group {
        flex: 1;
        min-width: 200px;
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }
    .form-group input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }
    .form-group input[type="text"]:focus {
        border-color: #2196F3;
        outline: none;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.2);
    }
    .button-group {
        text-align: center;
        margin-top: 10px;
    }
    .btn {
        padding: 10px 30px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
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
        text-align: center;
        margin-bottom: 20px;
    }
    .link-group a {
        color: #4CAF50;
        text-decoration: none;
        font-size: 14px;
    }
    .link-group a:hover {
        text-decoration: underline;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .data-table th,
    .data-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        vertical-align: middle;
    }
    .data-table th {
        background-color: #f5f5f5;
        font-weight: bold;
        color: #333;
    }
    .data-table th.sortable {
        white-space: nowrap;
    }
    .sort-link {
        color: #666;
        text-decoration: none;
        margin-left: 5px;
        font-size: 12px;
    }
    .sort-link:hover {
        color: #2196F3;
    }
    .data-table tbody tr:hover {
        background-color: #f9f9f9;
    }
    .no-data {
        text-align: center;
        color: #888;
        padding: 30px;
    }
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 30px;
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
    }
    .pagination-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 15px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .pagination-arrow:hover {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
    }
    .separator {
        margin: 0 10px;
        color: #ccc;
    }
    .btn-edit {
        display: inline-block;
        padding: 6px 15px;
        background-color: #f39c12;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        white-space: nowrap;
    }
    .btn-edit:hover {
        background-color: #e67e22;
    }
    .flash-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        text-align: center;
    }
    @media (max-width: 768px) {
        .admin-container {
            margin: 20px 16px;
            padding: 20px;
        }
        .form-row {
            flex-direction: column;
        }
        .data-table {
            font-size: 13px;
        }
        .data-table th,
        .data-table td {
            padding: 10px 8px;
        }
    }
</style>
@endsection