@extends('admin.login-layout')
@section('title', '管理者ログイン')

@section('content')
<div class="container">
    <h1>管理者ログイン</h1>
    
    @if ($errors->has('login'))
        <div class="error-message">{{ $errors->first('login') }}</div>
    @elseif ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
            <label>ログインID</label>
            <input type="text" name="login_id" value="{{ old('login_id') }}" autocomplete="username">
        </div>
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" autocomplete="current-password">
        </div>
        <div class="button-group">
            <button type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection