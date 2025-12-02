@extends('member.layout')
@section('title', 'メールアドレス変更認証')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="form-container">
    <h1>メールアドレス変更認証</h1>

    <div class="info-message">
        <p>変更後のメールアドレスに認証コードを送信しました。</p>
        <p>メールに記載されている認証コードを入力してください。</p>
    </div>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('email.complete') }}">
        @csrf

        <div class="form-group">
            <label for="auth_code">認証コード</label>
            <input type="text" name="auth_code" id="auth_code" value="{{ old('auth_code') }}" class="form-control" placeholder="6桁の数字">
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">認証コードを送信してメールアドレスの変更を完了する</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<style>
    .form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .form-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .info-message {
        background-color: #e3f2fd;
        border: 1px solid #2196F3;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 6px;
    }
    .info-message p {
        font-size: 15px;
        color: #1565c0;
        line-height: 1.6;
        margin-bottom: 10px;
    }
    .info-message p:last-child {
        margin-bottom: 0;
    }
    .error-message {
        background-color: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }
    .error-message div {
        margin-bottom: 8px;
    }
    .error-message div:last-child {
        margin-bottom: 0;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: bold;
        font-size: 15px;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
    }
    .button-group {
        margin-top: 30px;
    }
    .btn {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }
    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }
    .btn-primary:hover {
        background-color: #45a049;
    }
    @media (max-width: 768px) {
        .form-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
    }
</style>
@endsection