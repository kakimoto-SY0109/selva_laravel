@extends('member.layout')
@section('title', '会員情報変更')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="form-container">
    <h1>会員情報変更</h1>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('profile.confirm') }}">
        @csrf

        <div class="form-group">
            <label for="name_sei">氏名（姓）</label>
            <input type="text" name="name_sei" id="name_sei" value="{{ old('name_sei', $member->name_sei) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="name_mei">氏名（名）</label>
            <input type="text" name="name_mei" id="name_mei" value="{{ old('name_mei', $member->name_mei) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="nickname">ニックネーム</label>
            <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $member->nickname) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>性別</label>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" name="gender" value="1" {{ old('gender', $member->gender) == 1 ? 'checked' : '' }}>
                    男性
                </label>
                <label class="radio-label">
                    <input type="radio" name="gender" value="2" {{ old('gender', $member->gender) == 2 ? 'checked' : '' }}>
                    女性
                </label>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">確認画面へ</button>
            <a href="{{ route('mypage') }}" class="btn btn-secondary">マイページに戻る</a>
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
    .radio-group {
        display: flex;
        gap: 20px;
    }
    .radio-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: normal;
        cursor: pointer;
    }
    .radio-label input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
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
        text-decoration: none;
        text-align: center;
        display: block;
    }
    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }
    .btn-primary:hover {
        background-color: #45a049;
    }
    .btn-secondary {
        background-color: #888;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #666;
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