@extends('admin.layout')
@section('title', $isEdit ? '商品編集確認' : '商品登録確認')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '商品編集確認' : '商品登録確認' }}</h1>

    <div class="confirm-box">
        <table class="confirm-table">
            <tr>
                <th>ID</th>
                <td>{{ $isEdit ? $formData['id'] : '登録後に自動採番' }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $formData['name'] }}</td>
            </tr>
            <tr>
                <th>会員</th>
                <td>{{ $memberName }}</td>
            </tr>
            <tr>
                <th>商品カテゴリ大</th>
                <td>{{ $categoryName }}</td>
            </tr>
            <tr>
                <th>商品カテゴリ小</th>
                <td>{{ $subcategoryName }}</td>
            </tr>
            @for ($i = 1; $i <= 4; $i++)
                @if (!empty($formData['image_' . $i]))
                    <tr>
                        <th>商品写真{{ $i }}</th>
                        <td>
                            <img src="{{ asset('storage/' . $formData['image_' . $i]) }}" alt="商品写真{{ $i }}" class="confirm-image">
                        </td>
                    </tr>
                @endif
            @endfor
            <tr>
                <th>商品説明</th>
                <td>{!! nl2br(e($formData['product_content'])) !!}</td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ $isEdit ? route('admin.products.update') : route('admin.products.store') }}" id="complete-form">
            @csrf
            <button type="submit" class="btn-primary">{{ $isEdit ? '編集完了' : '登録完了' }}</button>
        </form>
        <form method="POST" action="{{ route('admin.products.back') }}">
            @csrf
            <button type="submit" class="btn-secondary">前に戻る</button>
        </form>
    </div>
</div>

<style>
.confirm-box {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 30px;
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

.confirm-image {
    max-width: 200px;
    max-height: 200px;
    border: 1px solid #ddd;
    border-radius: 4px;
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