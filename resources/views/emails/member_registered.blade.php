<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box dt {
            font-weight: bold;
            color: #555;
            margin-top: 10px;
        }
        .info-box dt:first-child {
            margin-top: 0;
        }
        .info-box dd {
            margin: 5px 0 0 20px;
            color: #333;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>会員登録完了のお知らせ</h1>
        </div>

        <div class="content">
            <p>{{ $member->name_sei }} {{ $member->name_mei }} 様</p>
            
            <p>この度は会員登録いただき、誠にありがとうございます。<br>
            以下の内容で会員登録が完了いたしました。</p>

            <div class="info-box">
                <dl>
                    <dt>お名前</dt>
                    <dd>{{ $member->name_sei }} {{ $member->name_mei }}</dd>
                    
                    <dt>ニックネーム</dt>
                    <dd>{{ $member->nickname }}</dd>
                    
                    <dt>メールアドレス（ログインID）</dt>
                    <dd>{{ $member->email }}</dd>
                    
                    <dt>性別</dt>
                    <dd>{{ $member->gender == 1 ? '男性' : '女性' }}</dd>
                </dl>
            </div>

            <p>今後は、ご登録いただいたメールアドレスとパスワードでログインしてサービスをご利用いただけます。</p>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">ログインはこちら</a>
            </div>

            <p style="color: #c33; font-size: 14px; margin-top: 20px;">
                ※このメールにお心当たりがない場合は、お手数ですが削除していただきますようお願いいたします。
            </p>
        </div>
    </div>
</body>
</html>