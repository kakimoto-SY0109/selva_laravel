@extends('member.layout')
@section('title', 'マイページ')

@section('header_buttons')
    <a href="{{ route('top') }}">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection

@section('content')
<div class="mypage-container">
    <h1>マイページ</h1>
    
    <div class="member-info-section">
        <h2>会員情報</h2>
        
        <div class="info-item">
            <div class="info-label">氏名</div>
            <div class="info-value">{{ $member->name_sei }}{{ $member->name_mei }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">ニックネーム</div>
            <div class="info-value">{{ $member->nickname }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">性別</div>
            <div class="info-value">
                @if($member->gender == 1)
                    男性
                @elseif($member->gender == 2)
                    女性
                @else
                    その他
                @endif
            </div>
        </div>

        <div class="info-item">
            <div class="info-label">メールアドレス</div>
            <div class="info-value">{{ $member->email }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">パスワード</div>
            <div class="info-value security">セキュリティのため非表示</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .mypage-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .mypage-container h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 30px;
        color: #333;
    }
    .member-info-section {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 6px;
        margin-bottom: 30px;
        border: 1px solid #eee;
    }
    .member-info-section h2 {
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
        padding-bottom: 10px;
        border-bottom: 2px solid #2196F3;
    }
    .info-item {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #ddd;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        width: 200px;
        font-size: 15px;
        color: #666;
        font-weight: bold;
        flex-shrink: 0;
    }
    .info-value {
        flex: 1;
        font-size: 15px;
        color: #333;
    }
    .info-value.security {
        color: #888;
        font-style: italic;
    }
    .button-group {
        text-align: center;
        margin-bottom: 20px;
    }
    .button-group form {
        display: inline-block;
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
    .btn-logout {
        background-color: #f44336;
        color: white;
    }
    .btn-logout:hover {
        background-color: #d32f2f;
    }
    @media (max-width: 768px) {
        .mypage-container {
            margin: 30px 16px;
            width: calc(100% - 32px);
            padding: 20px;
        }
        .info-item {
            flex-direction: column;
            gap: 8px;
        }
        .info-label {
            width: 100%;
        }
    }
</style>
@endsection