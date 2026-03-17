<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipe Manager')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        nav {
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .auth-links {
            float: right;
        }
        .auth-links a {
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-left: 8px;
        }
        .btn-login {
            background-color: #28a745;
            color: white;
        }
        .btn-login:hover {
            background-color: #218838;
            color: white;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
        }
        .btn-logout:hover {
            background-color: #c82333;
            color: white;
        }
        .alert {
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <h2>Recipe Manager</h2>

    <nav class="clearfix">
        <a href="{{ route('recipes.index') }}">All Recipes</a>

        @if(session('logged_in'))
            <a href="{{ route('recipes.create') }}">Create Recipe</a>
        @endif

        <span class="auth-links">
            @if(session('logged_in'))
                <span style="color: green; margin-right: 10px;">✔ Logged In</span>
                <a href="/logout-demo" class="btn-logout">Demo Logout</a>
            @else
                <a href="/login-demo" class="btn-login">Demo Login</a>
            @endif
        </span>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</body>
</html>