@extends('admin.layout')
@section('title', 'レビュー詳細')
@section('content')
<div class="container">
    <h1>レビュー詳細</h1>

    <div class="detail-box">
        <table class="detail-table">
            <tr>
                <th>ID</th>
                <td>{{ $review->id }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>
                    <a href="{{ route('admin.products.show', $review->product->id) }}" class="link">
                        {{ $review->product->name }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>投稿者</th>
                <td>
                    <a href="{{ route('admin.members.show', $review->member->id) }}" class="link">
                        {{ $review->member->name_sei }} {{ $review->member->name_mei }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>評価</th>
                <td>
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->evaluation)
                                <span class="star filled">★</span>
                            @else
                                <span class="star empty">★</span>
                            @endif
                        @endfor
                    </span>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>{!! nl2br(e($review->comment)) !!}</td>
            </tr>
            <tr>
                <th>登録日時</th>
                <td>{{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <th>更新日時</th>
                <td>{{ $review->updated_at ? $review->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <a href="{{ route('admin.products.show', $review->product->id) }}" class="btn-secondary">商品詳細に戻る</a>
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
    vertical-align: top;
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
.link {
    color: #5dade2;
    text-decoration: none;
}
.link:hover {
    text-decoration: underline;
}
.stars {
    display: inline-flex;
    gap: 2px;
}
.star {
    font-size: 20px;
}
.star.filled {
    color: #f39c12;
}
.star.empty {
    color: #ddd;
}
.button-group {
    display: flex;
    gap: 15px;
    justify-content: center;
}
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
    .btn-secondary {
        width: 100%;
    }
}
</style>
@endsection