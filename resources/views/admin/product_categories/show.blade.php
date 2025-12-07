@extends('admin.layout')
@section('title', '商品カテゴリ詳細')
@section('content')
<div class="container">
    <h1>商品カテゴリ詳細</h1>

    <div class="detail-box">
        <table class="detail-table">
            <tr>
                <th>ID</th>
                <td>{{ $category->id }}</td>
            </tr>
            <tr>
                <th>商品大カテゴリ</th>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>商品小カテゴリ</th>
                <td>
                    @if($category->subcategories->count() > 0)
                        {{ $category->subcategories->pluck('name')->implode(', ') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>登録日時</th>
                <td>{{ $category->created_at ? $category->created_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <th>更新日時</th>
                <td>{{ $category->updated_at ? $category->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <a href="{{ route('admin.product_categories.edit', $category->id) }}" class="btn-primary">編集</a>
        <form method="POST" action="{{ route('admin.product_categories.destroy', $category->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">削除</button>
        </form>
        <a href="{{ route('admin.product_categories.index') }}" class="btn-secondary">一覧に戻る</a>
    </div>
</div>

<style>
.detail-box {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 30px;
}

.detail-table {
    width: 100%;
    border-collapse: collapse;
}

.detail-table th,
.detail-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.detail-table th {
    width: 200px;
    font-weight: bold;
    color: #555;
    background-color: #fafafa;
}

.detail-table td {
    color: #333;
}

.detail-table tr:last-child th,
.detail-table tr:last-child td {
    border-bottom: none;
}

.button-group {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary,
.btn-danger,
.btn-secondary {
    padding: 12px 50px;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background-color: #5dade2;
    color: white;
}

.btn-primary:hover {
    background-color: #3498db;
}

.btn-danger {
    background-color: #e74c3c;
    color: white;
}

.btn-danger:hover {
    background-color: #c0392b;
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
}

@media (max-width: 768px) {
    .detail-box {
        padding: 20px;
    }
    
    .detail-table th {
        width: 120px;
        font-size: 13px;
    }
    
    .detail-table td {
        font-size: 13px;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-danger,
    .btn-secondary {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .detail-table {
        font-size: 12px;
    }
    
    .detail-table th,
    .detail-table td {
        padding: 10px;
    }
    
    .detail-table th {
        width: 100px;
    }
}
</style>
@endsection