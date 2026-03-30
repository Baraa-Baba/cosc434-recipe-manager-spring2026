<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipe Manager')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 25px;
            background: #eef1f5;
            color: #222;
        }
        h2 { margin-bottom: 10px; }
        .navbar {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 0;
            border-bottom: 2px solid #ccc;
            margin-bottom: 18px;
        }
        .navbar a {
            text-decoration: none;
            color: #444;
            font-weight: 500;
        }
        .navbar a:hover { color: #000; }
        .spacer { flex: 1; }
        .badge {
            font-size: 13px;
            color: #0a7a2e;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 7px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
        .btn-green { background: #2d9e52; color: #fff; }
        .btn-green:hover { background: #24844a; color: #fff; }
        .btn-red { background: #c9302c; color: #fff; }
        .btn-red:hover { background: #a82824; color: #fff; }
        .msg {
            padding: 12px 18px;
            border-radius: 5px;
            margin-bottom: 16px;
            font-size: 15px;
        }
        .msg-ok {
            background: #dff0d8;
            color: #3c763d;
            border: 1px solid #b2dba1;
        }
        .msg-fail {
            background: #fce4e4;
            color: #8a1f11;
            border: 1px solid #f5c2c2;
        }
    </style>
</head>
<body>
    <h2>🍴 Recipe Manager</h2>

    <div class="navbar">
        <a href="{{ route('recipes.index') }}">📋 Browse Recipes</a>

        @if(session('logged_in'))
            <a href="{{ route('recipes.create') }}">➕ New Recipe</a>
        @endif

        <div class="spacer"></div>

        @if(session('logged_in'))
            <span class="badge">● Active Session</span>
            <a href="/logout-demo" class="btn btn-red">End Demo</a>
        @else
            <a href="/login-demo" class="btn btn-green">Start Demo</a>
        @endif
    </div>

    @if(session('success'))
        <div class="msg msg-ok">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="msg msg-fail">{{ session('error') }}</div>
    @endif

    @yield('content')

</body>
</html>