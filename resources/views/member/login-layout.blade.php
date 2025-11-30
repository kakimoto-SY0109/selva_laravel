<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '会員サイト')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #00897B;
            color: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .welcome-message {
            flex: 1;
        }
        .site-name {
            font-size: 24px;
            font-weight: bold;
        }
        .user-greeting {
            font-size: 16px;
            margin-top: 5px;
            font-weight: normal;
        }
        .header-buttons {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }
        .header-buttons a,
        .header-buttons button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .header-buttons a:hover,
        .header-buttons button:hover {
            background-color: #45a049;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .error-message {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .error-messages {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .error-messages ul {
            margin-left: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        .radio-group {
            display: flex;
            gap: 20px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            font-weight: normal;
        }
        .radio-group input[type="radio"] {
            margin-right: 5px;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .link-group {
            margin-top: 20px;
            text-align: center;
        }
        .link-group a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 14px;
        }
        .link-group a:hover {
            text-decoration: underline;
        }
        .separator {
            margin: 10px 0;
        }
        @media (max-width: 480px) {
            .container { 
                margin: 30px 16px;
                width: calc(100% - 32px);
            }
            .header-buttons a,
            .header-buttons button {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="welcome-message">
                <div class="site-name">⚪︎⚪︎サイト</div>
                @auth('member')
                    <div>ようこそ {{ Auth::guard('member')->user()->full_name }} 様</div>
                @endauth
            </div>
            <div class="header-buttons">
                @auth('member')
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">ログイン</a>
                    <a href="{{ route('member.register') }}">新規会員登録</a>
                @endauth
            </div>
        </div>
    </header>
    <main>@yield('content')</main>
</body>
</html>