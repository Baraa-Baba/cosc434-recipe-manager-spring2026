<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipe Manager')</title>
</head>
<body>
    <h2> Recipe Manager</h2>

    <nav>
        <a href="{{ route('recipes.index') }}">All Recipes</a>
        <a href="{{ route('recipes.create') }}">Create Recipe</a>
    </nav>
    @if(session('success'))
    <div>{{ session('success') }}</div>
    @endif
    @yield('content')

</body>
</html>