@extends('member.layout')
@section('title', '会員登録確認')

@section('content')
<div class="container" style="max-width: 600px;">
    <h1>会員登録確認</h1>
    
    <p style="margin-bottom: 20px; color: #666;">以下の内容で登録します。よろしければ「登録する」ボタンを押してください。</p>

    <div class="confirm-section">
        <div class="confirm-label">氏名（姓）</div>
        <div class="confirm-value">{{ $formData['name_sei'] }}</div>
    </div>

    <div class="confirm-section">
        <div class="confirm-label">氏名（名）</div>
        <div class="confirm-value">{{ $formData['name_mei'] }}</div>
    </div>

    <div class="confirm-section">
        <div class="confirm-label">ニックネーム</div>
        <div class="confirm-value">{{ $formData['nickname'] }}</div>
    </div>

    <div class="confirm-section">
        <div class="confirm-label">性別</div>
        <div class="confirm-value">{{ $genders[$formData['gender']] }}</div>
    </div>

    <div class="confirm-section">
        <div class="confirm-label">メールアドレス（ログインID）</div>
        <div class="confirm-value">{{ $formData['email'] }}</div>
    </div>

    <div class="confirm-section">
        <div class="confirm-label">パスワード</div>
        <div class="confirm-value security-notice">セキュリティのため非表示</div>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ route('member.complete') }}" style="margin: 0;" id="registerForm">
            @csrf
            <button type="submit" class="btn-submit" id="submitBtn">登録する</button>
        </form>

        <form method="POST" action="{{ route('member.back') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-back">戻る</button>
        </form>
    </div>
</div>

<script>
    // 二重送信防止
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = '登録中...';
        submitBtn.style.backgroundColor = '#ccc';
    });
</script>

<style>
    .confirm-section {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .confirm-label {
        font-weight: bold;
        color: #555;
        margin-bottom: 8px;
    }
    .confirm-value {
        color: #333;
        font-size: 16px;
    }
    .security-notice {
        color: #999;
        font-style: italic;
    }
    .btn-back {
        background-color: #888;
    }
    .btn-back:hover {
        background-color: #666;
    }
    .btn-submit {
        background-color: #4CAF50;
    }
    .btn-submit:hover {
        background-color: #45a049;
    }
</style>
@endsection