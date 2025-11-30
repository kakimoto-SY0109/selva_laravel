@extends('member.layout')
@section('title', '会員登録完了')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="success-icon">✓</div>
    <h1>会員登録が完了しました</h1>
    <div class="message">
        会員登録ありがとうございます。<br>
        登録いただいたメールアドレスとパスワードでログインできます。
    </div>
    
    <!-- メール送信通知 -->
    <div class="email-notice">
        <strong>📧 登録完了メールを送信しました</strong>
        <div class="email-address">{{ $member->email }}</div>
        <small>※メールが届かない場合は、迷惑メールフォルダをご確認ください。</small>
    </div>
    
    <div class="button-group">
        <a href="{{ route('top') }}" class="btn">トップに戻る</a>
    </div>
</div>

<style>
    .container {
        text-align: center;
    }
    .success-icon {
        font-size: 80px;
        color: #4CAF50;
        margin-bottom: 20px;
    }
    .message {
        color: #666;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 40px;
    }
    .email-notice {
        background-color: #e3f2fd;
        border-left: 4px solid #2196F3;
        padding: 15px;
        margin: 20px 0 30px;
        text-align: left;
        border-radius: 4px;
    }
    .email-notice strong {
        color: #1976D2;
        display: block;
        margin-bottom: 5px;
    }
    .email-address {
        color: #333;
        font-weight: bold;
        margin: 5px 0;
    }
    .email-notice small {
        color: #666;
        font-size: 13px;
    }
    .button-group a {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 12px 40px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 16px;
    }
    .button-group a:hover {
        background-color: #45a049;
    }
</style>
@endsection