@extends('member.layout')
@section('title', '退会')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="withdraw-container">
    <h1>退会</h1>
    
    <div class="warning-section">
        <p class="warning-text">退会すると、会員情報が削除されます。</p>
        <p class="warning-text">本当に退会してもよろしいですか?</p>
    </div>

    <div class="button-group">
        <form method="POST" action="{{ route('withdraw.post') }}">
            @csrf
            <button type="submit" class="btn btn-danger">退会する</button>
        </form>
        
        <a href="{{ route('mypage') }}" class="btn btn-secondary">マイページに戻る</a>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .withdraw-container {
        max-width: 600px;
        margin: 80px auto;
        padding: 50px 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }
    .withdraw-container h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 40px;
    }
    .warning-section {
        margin-bottom: 40px;
        padding: 30px;
        background-color: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 6px;
    }
    .warning-text {
        font-size: 16px;
        color: #856404;
        line-height: 1.8;
        margin-bottom: 10px;
    }
    .warning-text:last-child {
        margin-bottom: 0;
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
        display: block;
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
    }
    .btn-danger {
        background-color: #f44336;
        color: white;
    }
    .btn-danger:hover {
        background-color: #d32f2f;
    }
    .btn-secondary {
        background-color: #888;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #666;
    }
    @media (max-width: 768px) {
        .withdraw-container {
            margin: 60px 16px;
            width: calc(100% - 32px);
            padding: 30px 20px;
        }
    }
</style>
@endsection