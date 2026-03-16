@extends('layouts.app')

@section('title','All Recipes')

@section('content')
<h3>All Recipes</h3>
@if ($recipes->isEmpty())
<p>No recipes yet. <a href="{{ route('recipes.create') }}">Add</a></p>
@else
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recipes as $recipe )
        <tr>
            <td>{{ $recipe->name }}</td>
            <td><a href="{{ route('recipes.show', $recipe) }}">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection