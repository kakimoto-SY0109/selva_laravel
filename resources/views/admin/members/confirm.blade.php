@extends('admin.layout')
@section('title', $isEdit ? '会員編集確認' : '会員登録確認')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '会員編集確認' : '会員登録確認' }}</h1>

    <div class="confirm-box">
        <table class="confirm-table">
            @if($isEdit)
            <tr>
                <th>ID</th>
                <td>{{ $memberId }}</td>
            </tr>
            @endif
            <tr>
                <th>氏名（姓）</th>
                <td>{{ $formData['name_sei'] }}</td>
            </tr>
            <tr>
                <th>氏名（名）</th>
                <td>{{ $formData['name_mei'] }}</td>
            </tr>
            <tr>
                <th>ニックネーム</th>
                <td>{{ $formData['nickname'] }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>{{ $genders[$formData['gender']] }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $formData['email'] }}</td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>
                    @if(isset($formData['password']) && !empty($formData['password']))
                        セキュリティのため非表示
                    @else
                        {{ $isEdit ? '変更なし' : '' }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ $isEdit ? route('admin.members.update') : route('admin.members.store') }}" id="complete-form">
            @csrf
            <button type="submit" class="btn-primary">{{ $isEdit ? '編集完了' : '登録完了' }}</button>
        </form>
        <form method="POST" action="{{ route('admin.members.back') }}">
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
    .container {
        padding: 20px;
    }
    
    h1 {
        font-size: 1.5em;
        margin-bottom: 20px;
    }
    
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

@media (max-width: 480px) {
    .confirm-table {
        font-size: 12px;
    }
    
    .confirm-table th,
    .confirm-table td {
        padding: 10px;
    }
    
    .confirm-table th {
        width: 100px;
    }
}
</style>

<script>
// 二重送信防止
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