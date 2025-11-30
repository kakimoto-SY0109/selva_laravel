@extends('member.login-layout')
@section('title', 'パスワード再設定')

@section('content')
<div class="container">
    <h1>パスワード再設定</h1>
    
    <p class="description">
        新しいパスワードを入力してください。
    </p>
    
    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="{{ route('member.password.update') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" autocomplete="new-password">
        </div>
        
        <div class="form-group">
            <label>パスワード確認</label>
            <input type="password" name="password_confirmation" autocomplete="new-password">
        </div>
        
        <div class="button-group">
            <button type="submit">リセット</button>
        </div>
    </form>
</div>

<style>
    .description {
        color: #666;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 30px;
        text-align: center;
    }
</style>
@endsection