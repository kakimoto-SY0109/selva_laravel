@extends('admin.layout')
@section('title', '会員一覧')
@section('content')
<div class="container">
    <h1>会員一覧</h1>

    {{-- 検索フォーム --}}
    <div class="search-box">
        <h2>会員検索</h2>
        <form method="GET" action="{{ route('admin.members.index') }}">
            <div class="search-row">
                <div class="search-item search-id">
                    <label>ID</label>
                    <input type="text" name="id" value="{{ request('id') }}" placeholder="ID">
                </div>
                
                <div class="search-item search-gender">
                    <label>性別</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="gender[]" value="1" 
                                {{ is_array(request('gender')) && in_array('1', request('gender')) ? 'checked' : '' }}>
                            男性
                        </label>
                        <label>
                            <input type="checkbox" name="gender[]" value="2" 
                                {{ is_array(request('gender')) && in_array('2', request('gender')) ? 'checked' : '' }}>
                            女性
                        </label>
                    </div>
                </div>
                
                <div class="search-item search-keyword">
                    <label>フリーワード</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="氏名・メールアドレス">
                </div>
            </div>

            {{-- 並び替えのパラメータを保持 --}}
            <input type="hidden" name="sort" value="{{ request('sort', 'id') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">

            <div class="search-buttons">
                <button type="submit" class="btn-search">検索する</button>
            </div>
        </form>
    </div>

    {{-- 会員一覧テーブル --}}
    <div class="table-wrapper">
        <table class="member-table">
            <thead>
                <tr>
                    <th class="col-id">
                        ID
                        <a href="{{ route('admin.members.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-btn">
                            @if(request('sort') === 'id')
                                {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @else
                                ▼
                            @endif
                        </a>
                    </th>
                    <th class="col-name">氏名</th>
                    <th class="col-gender">性別</th>
                    <th class="col-email">メールアドレス</th>
                    <th class="col-date">
                        登録日時
                        <a href="{{ route('admin.members.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-btn">
                            @if(request('sort') === 'created_at')
                                {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @else
                                ▼
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td class="col-id">{{ $member->id }}</td>
                    <td class="col-name">{{ $member->name_sei }} {{ $member->name_mei }}</td>
                    <td class="col-gender">{{ $member->gender == 1 ? '男性' : '女性' }}</td>
                    <td class="col-email">{{ $member->email }}</td>
                    <td class="col-date">{{ $member->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="no-data">該当する会員が見つかりませんでした</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ページネーション --}}
    @if($members->hasPages())
    <div class="pagination-container">
        {{-- 前へボタン --}}
        @if($members->onFirstPage())
            <span class="pagination-disabled">‹</span>
        @else
            <a href="{{ $members->previousPageUrl() }}" class="pagination-link">‹</a>
        @endif

        {{-- ページ番号（3ページ分ずつ表示） --}}
        @php
            $currentPage = $members->currentPage();
            $lastPage = $members->lastPage();
            
            // 3ページずつ表示するための計算
            $startPage = floor(($currentPage - 1) / 3) * 3 + 1;
            $endPage = min($startPage + 2, $lastPage);
        @endphp

        @for($i = $startPage; $i <= $endPage; $i++)
            @if($i == $currentPage)
                <span class="pagination-current">{{ $i }}</span>
            @else
                <a href="{{ $members->url($i) }}" class="pagination-link">{{ $i }}</a>
            @endif
        @endfor

        {{-- 次へボタン --}}
        @if($members->hasMorePages())
            <a href="{{ $members->nextPageUrl() }}" class="pagination-link">›</a>
        @else
            <span class="pagination-disabled">›</span>
        @endif
    </div>
    @endif

    {{-- トップに戻るリンク --}}
    <div class="back-link">
        <a href="{{ route('admin.top') }}">トップに戻る</a>
    </div>
</div>

<style>
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
    grid-template-columns: 150px 250px 1fr;
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

.checkbox-group {
    display: flex;
    gap: 20px;
    padding-top: 3px;
}

.checkbox-group label {
    font-weight: normal;
    display: flex;
    align-items: center;
    margin-bottom: 0;
    cursor: pointer;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 6px;
    cursor: pointer;
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

.member-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}

.member-table th {
    background: linear-gradient(to bottom, #fafafa, #f5f5f5);
    padding: 14px 12px;
    text-align: left;
    font-weight: bold;
    color: #333;
    font-size: 14px;
    border-bottom: 2px solid #e0e0e0;
    white-space: nowrap;
}

.member-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
    color: #333;
}

.member-table tbody tr {
    transition: background-color 0.2s;
}

.member-table tbody tr:hover {
    background-color: #f9f9f9;
}

.member-table tbody tr:last-child td {
    border-bottom: none;
}

.col-id {
    width: 80px;
    text-align: center;
}

.col-name {
    width: 200px;
}

.col-gender {
    width: 80px;
    text-align: center;
}

.col-email {
    min-width: 250px;
}

.col-date {
    width: 180px;
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

@media (max-width: 768px) {
    .search-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .table-wrapper {
        border-radius: 0;
        margin-left: -30px;
        margin-right: -30px;
    }
}
</style>
@endsection