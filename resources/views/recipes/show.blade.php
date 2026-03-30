@extends('layouts.app')
@section('title', $recipe->name)
@section('content')

<h3>{{ $recipe->name }}</h3>

<p><strong>About:</strong><br>
{{ $recipe->description }}</p>

<p><strong>Ingredients:</strong><br>
{{ $recipe->ingredients }}</p>

<p><strong>Steps:</strong><br>
{{ $recipe->instructions }}</p>

@if(session('logged_in'))
<hr>
<a href="{{ route('recipes.edit', $recipe) }}">✏️ Edit</a>
&nbsp;|&nbsp;
<form action="{{ route('recipes.destroy', $recipe) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure you want to remove this recipe?')">🗑️ Delete</button>
</form>
@endif

@endsection
