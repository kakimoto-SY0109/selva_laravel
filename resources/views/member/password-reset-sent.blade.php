@extends('member.login-layout')
@section('title', 'メール送信完了')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="success-icon">📧</div>
    <h1>メール送信完了</h1>
    <div class="message">
        パスワード再設定用のメールを送信しました。<br>
        メールに記載されているURLから<br>
        パスワードの再設定を行ってください。
    </div>
    
    <!-- メール送信通知 -->
    <div class="email-notice">
        <strong>📧 パスワード再設定メールを送信しました</strong>
        <small style="display: block; margin-top: 10px;">
            ※メールが届かない場合は、迷惑メールフォルダをご確認ください。<br>
            ※URLの有効期限は送信から60分間です。
        </small>
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
        margin-bottom: 20px;
    }
    .message {
        color: #666;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 30px;
    }
    .email-notice {
        background-color: #fff3e0;
        border-left: 4px solid #FF9800;
        padding: 15px;
        margin: 20px 0 30px;
        text-align: left;
        border-radius: 4px;
    }
    .email-notice strong {
        color: #e65100;
        display: block;
        margin-bottom: 5px;
    }
    .email-notice small {
        color: #666;
        font-size: 13px;
        line-height: 1.6;
    }
    .button-group {
        margin-top: 30px;
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