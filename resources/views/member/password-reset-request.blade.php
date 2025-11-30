@extends('member.login-layout')

@section('title', 'パスワード再設定')

@section('content')
<div class="container">
    <h1>パスワード再設定</h1>
    
    <p class="description">
        ご登録のメールアドレスを入力してください。<br>
        パスワード再設定用のメールをお送りします。
    </p>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('member.password.email') }}">
        @csrf
        
        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
        </div>

        <div class="button-group">
            <button type="submit">送信する</button>
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