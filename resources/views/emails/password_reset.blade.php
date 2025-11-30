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
            background-color: #FF9800;
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
            background-color: #fff3e0;
            border-left: 4px solid #FF9800;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #e65100;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 16px;
        }
        .url-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            word-break: break-all;
            font-size: 13px;
            color: #666;
        }
        .notice {
            color: #666;
            font-size: 14px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>パスワード再設定のご案内</h1>
        </div>

        <div class="content">
            <p>{{ $member->name_sei }} {{ $member->name_mei }} 様</p>
            
            <p>パスワード再設定のリクエストを受け付けました。<br>
            以下のボタンをクリックして、新しいパスワードを設定してください。</p>

            <div class="info-box">
                ⚠️ このメールは、パスワード再設定のリクエストがあった方にのみ送信されています。
            </div>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">パスワードを再設定する</a>
            </div>

            <p style="color: #666; font-size: 14px; margin-top: 30px;">
                ボタンをクリックできない場合は、下記URLをコピーしてブラウザのアドレスバーに貼り付けてアクセスしてください。
            </p>

            <div class="url-box">
                {{ $resetUrl }}
            </div>

            <div class="notice">
                <p style="color: #c33; margin: 10px 0 0 0;">
                    ※このメールにお心当たりがない場合は、お手数ですが削除していただきますようお願いいたします。
                </p>
            </div>
        </div>
    </div>
</body>
</html>