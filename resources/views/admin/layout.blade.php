<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '管理画面')</title>
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
            background-color: #808080;
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
            background-color: #a0a0a0;
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
            background-color: #909090;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2em;
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
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #5dade2;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        button,
        .btn {
            width: 100%;
            background-color: #5dade2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        button:hover,
        .btn:hover {
            background-color: #3498db;
        }
        @media (max-width: 768px) {
            .container { 
                margin: 30px 16px;
                width: calc(100% - 32px);
                padding: 20px;
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
                <div class="site-name">管理画面</div>
                @auth('admin')
                    <div class="user-greeting">ようこそ {{ Auth::guard('admin')->user()->name }} さん</div>
                @endauth
            </div>
            <div class="header-buttons">
                @auth('admin')
                    <a href="{{ route('admin.members.index') }}">会員一覧</a>
                    <a href="{{ route('admin.product_categories.index') }}">商品カテゴリ一覧</a>
                    <a href="{{ route('admin.products.index') }}">商品一覧</a>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                @endif
            </div>
        </div>
    </header>
    <main>@yield('content')</main>
    @yield('scripts')
</body>
</html>