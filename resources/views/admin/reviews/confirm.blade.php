@extends('admin.layout')
@section('title', $isEdit ? '商品レビュー編集確認' : '商品レビュー登録確認')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品レビュー編集確認' : '商品レビュー登録確認' }}</h1>

    {{-- 商品情報と総合評価 --}}
    <div class="product-info-box">
        <h2>商品情報</h2>
        <table class="info-table">
            <tr>
                <th>商品名</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>総合評価</th>
                <td>
                    @if($averageRating > 0)
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $averageRating)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star empty">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="rating-number">{{ $averageRating }}</span>
                    @else
                        <span class="no-rating">評価なし</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="confirm-box">
        <h2>入力内容確認</h2>
        <table class="confirm-table">
            <tr>
                <th>ID</th>
                <td>{{ $isEdit ? $formData['id'] : '登録後に自動採番' }}</td>
            </tr>
            <tr>
                <th>商品</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>会員</th>
                <td>{{ $memberName }}</td>
            </tr>
            <tr>
                <th>商品評価</th>
                <td>
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $formData['evaluation'])
                                <span class="star filled">★</span>
                            @else
                                <span class="star empty">★</span>
                            @endif
                        @endfor
                    </span>
                    {{ $formData['evaluation'] }}
                </td>
            </tr>
            <tr>
                <th>商品コメント</th>
                <td>{!! nl2br(e($formData['comment'])) !!}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ $isEdit ? route('admin.reviews.update') : route('admin.reviews.store') }}" id="complete-form">
            @csrf
            <button type="submit" class="btn-primary">{{ $isEdit ? '編集完了' : '登録完了' }}</button>
        </form>
        <form method="POST" action="{{ route('admin.reviews.back') }}">
            @csrf
            <button type="submit" class="btn-secondary">前に戻る</button>
        </form>
    </div>
</div>

<style>
.product-info-box {
    background-color: #e8f4fc;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #5dade2;
    margin-bottom: 30px;
}

.product-info-box h2 {
    font-size: 16px;
    margin-bottom: 15px;
    color: #333;
    padding-bottom: 10px;
    border-bottom: 2px solid #5dade2;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
}

.info-table th,
.info-table td {
    padding: 10px 15px;
    text-align: left;
}

.info-table th {
    width: 150px;
    font-weight: bold;
    color: #555;
}

.confirm-box {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 30px;
}

.confirm-box h2 {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
    padding-bottom: 10px;
    border-bottom: 2px solid #85d4f5;
}

.confirm-table {
    width: 100%;
    border-collapse: collapse;
}

.confirm-table th,
.confirm-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
    vertical-align: top;
}

.confirm-table th {
    width: 200px;
    font-weight: bold;
    color: #555;
    background-color: #fafafa;
}

.confirm-table td {
    color: #333;
}

.confirm-table tr:last-child th,
.confirm-table tr:last-child td {
    border-bottom: none;
}

.stars {
    display: inline-flex;
    gap: 2px;
}

.star {
    font-size: 18px;
}

.star.filled {
    color: #f39c12;
}

.star.empty {
    color: #ddd;
}

.rating-number {
    margin-left: 10px;
    font-weight: bold;
}

.no-rating {
    color: #888;
}

.button-group {
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
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
}

@media (max-width: 768px) {
    .product-info-box,
    .confirm-box {
        padding: 20px;
    }
    
    .confirm-table th {
        width: 120px;
        font-size: 13px;
    }
    
    .confirm-table td {
        font-size: 13px;
    }
    
    .button-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .button-group form {
        width: 100%;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        padding: 12px 20px;
    }
}
</style>

<script>
document.getElementById('complete-form').addEventListener('submit', function(e) {
    const submitButton = this.querySelector('button[type="submit"]');
    if (submitButton.disabled) {
        e.preventDefault();
        return false;
    }
    submitButton.disabled = true;
    submitButton.textContent = '処理中...';
});
</script>
@endsection