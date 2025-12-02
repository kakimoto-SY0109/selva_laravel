@extends('member.layout')
@section('title', '会員情報変更確認')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="confirm-container">
    <h1>会員情報変更確認</h1>

    <div class="confirm-section">
        <div class="confirm-item">
            <div class="confirm-label">氏名（姓）</div>
            <div class="confirm-value">{{ $data['name_sei'] }}</div>
        </div>

        <div class="confirm-item">
            <div class="confirm-label">氏名（名）</div>
            <div class="confirm-value">{{ $data['name_mei'] }}</div>
        </div>

        <div class="confirm-item">
            <div class="confirm-label">ニックネーム</div>
            <div class="confirm-value">{{ $data['nickname'] }}</div>
        </div>

        <div class="confirm-item">
            <div class="confirm-label">性別</div>
            <div class="confirm-value">{{ $data['gender'] == 1 ? '男性' : '女性' }}</div>
        </div>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <button type="submit" class="btn btn-primary">変更完了</button>
        </form>

        <form method="POST" action="{{ route('profile.back') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">前に戻る</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .confirm-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .confirm-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .confirm-section {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 6px;
        margin-bottom: 30px;
        border: 1px solid #eee;
    }
    .confirm-item {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #ddd;
    }
    .confirm-item:last-child {
        border-bottom: none;
    }
    .confirm-label {
        width: 200px;
        font-size: 15px;
        color: #666;
        font-weight: bold;
        flex-shrink: 0;
    }
    .confirm-value {
        flex: 1;
        font-size: 15px;
        color: #333;
    }
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .button-group form {
        width: 100%;
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
    .btn-secondary {
        background-color: #888;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #666;
    }
    @media (max-width: 768px) {
        .confirm-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .confirm-item {
            flex-direction: column;
            gap: 8px;
        }
        .confirm-label {
            width: 100%;
        }
    }
</style>
@endsection