@extends('admin.layout')
@section('title', $isEdit ? '会員編集' : '会員登録')
@section('content')
<div class="container">
    <h1>{{ $isEdit ? '会員編集' : '会員登録' }}</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.members.confirm') }}" id="member-form">
        @csrf
        <input type="hidden" name="is_edit" value="{{ $isEdit ? '1' : '0' }}">
        @if($isEdit)
            <input type="hidden" name="member_id" value="{{ $member->id }}">
        @endif

        {{-- ID --}}
        <div class="form-group">
            <label>ID</label>
            @if($isEdit)
                <div class="form-value">{{ $member->id }}</div>
            @else
                <div class="form-value">登録後に自動採番</div>
            @endif
        </div>

        {{-- 氏名（姓） --}}
        <div class="form-group">
            <label>氏名（姓）</label>
            <input type="text" name="name_sei" value="{{ old('name_sei', $isEdit ? $member->name_sei : '') }}" maxlength="20">
        </div>

        {{-- 氏名（名） --}}
        <div class="form-group">
            <label>氏名（名）</label>
            <input type="text" name="name_mei" value="{{ old('name_mei', $isEdit ? $member->name_mei : '') }}" maxlength="20">
        </div>

        {{-- ニックネーム --}}
        <div class="form-group">
            <label>ニックネーム</label>
            <input type="text" name="nickname" value="{{ old('nickname', $isEdit ? $member->nickname : '') }}" maxlength="10">
        </div>

        {{-- 性別 --}}
        <div class="form-group">
            <label>性別</label>
            <div class="radio-group">
                @foreach($genders as $value => $label)
                    <label>
                        <input type="radio" name="gender" value="{{ $value }}" 
                            {{ old('gender', $isEdit ? $member->gender : '') == $value ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- メールアドレス --}}
        <div class="form-group">
            <label>メールアドレス（ログインID）</label>
            <input type="email" name="email" value="{{ old('email', $isEdit ? $member->email : '') }}" maxlength="200">
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" autocomplete="new-password">
            @if($isEdit)
                <p class="help-text">変更する場合のみ入力してください</p>
            @endif
        </div>

        {{-- パスワード確認 --}}
        <div class="form-group">
            <label>パスワード確認</label>
            <input type="password" name="password_confirm" autocomplete="new-password">
        </div>

        <div class="button-group">
            <button type="submit" class="btn-primary">確認画面へ</button>
            <a href="{{ route('admin.members.index') }}" class="btn-secondary">一覧に戻る</a>
        </div>
    </form>
</div>

<style>
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
    font-size: 14px;
}

.form-value {
    padding: 10px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #666;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus {
    outline: none;
    border-color: #5dade2;
    box-shadow: 0 0 0 2px rgba(93, 173, 226, 0.1);
}

.radio-group {
    display: flex;
    gap: 20px;
}

.radio-group label {
    font-weight: normal;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.radio-group input[type="radio"] {
    margin-right: 6px;
}

.help-text {
    margin-top: 5px;
    font-size: 12px;
    color: #999;
}

.error-messages {
    background-color: #fee;
    border: 1px solid #fcc;
    color: #c33;
    padding: 15px 15px 15px 35px;
    margin-bottom: 25px;
    border-radius: 4px;
}

.error-messages ul {
    margin: 0;
    padding: 0;
    list-style-position: inside;
}

.error-messages li {
    margin-bottom: 5px;
}

.button-group {
    margin-top: 40px;
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
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
    text-align: center;
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
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .button-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        padding: 12px 20px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 15px;
    }
    
    .radio-group {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<script>
// 二重送信防止
document.getElementById('member-form').addEventListener('submit', function(e) {
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