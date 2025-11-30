@extends('member.login-layout')
@section('title', '会員登録')

@section('content')
<div class="container" style="max-width: 600px;">
    <h1>会員登録フォーム</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('member.confirm') }}">
        @csrf

        <div class="form-group">
            <label>氏名（姓）</label>
            <input type="text" name="name_sei" value="{{ old('name_sei') }}">
        </div>

        <div class="form-group">
            <label>氏名（名）</label>
            <input type="text" name="name_mei" value="{{ old('name_mei') }}">
        </div>

        <div class="form-group">
            <label>ニックネーム</label>
            <input type="text" name="nickname" value="{{ old('nickname') }}">
        </div>

        <div class="form-group">
            <label>性別</label>
            <div class="radio-group">
                @foreach($genders as $value => $label)
                    <label>
                        <input type="radio" name="gender" value="{{ $value }}" 
                            {{ old('gender') == $value ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>メールアドレス（ログインID）</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>パスワード確認</label>
            <input type="password" name="password_confirm">
        </div>

        <div class="button-group">
            <button type="submit">確認画面へ</button>
        </div>

        <div class="link-group">
            <a href="{{ route('top') }}">トップに戻る</a>
        </div>
    </form>
</div>
@endsection