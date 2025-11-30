@extends('member.login-layout')
@section('title', 'ログイン')

@section('content')
<div class="container">
    <h1>ログイン</h1>
    
    @if ($errors->has('login'))
        <div class="error-message">{{ $errors->first('login') }}</div>
    @elseif ($errors->any())
        <div class="error-message">IDもしくはパスワードが間違っています</div>
    @endif
    
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <label>メールアドレス（ログインID）</label>
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="email">
        </div>
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" autocomplete="current-password">
        </div>
        <div class="button-group">
            <button type="submit">ログイン</button>
        </div>
    </form>
    
    <div class="link-group">
        <a href="{{ route('member.password.request') }}">パスワードを忘れた方</a>
        <div class="separator">|</div>
        <a href="{{ route('top') }}">トップに戻る</a>
        <div class="separator">|</div>
        <a href="{{ route('member.register') }}">新規会員登録はこちら</a>
    </div>
</div>
@endsection