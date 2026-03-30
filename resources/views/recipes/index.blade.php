@extends('layouts.app')

@section('title', 'Recipes')

@section('content')
<h3>📋 Recipe List</h3>

@if ($recipes->count() === 0)
    <p>Nothing here yet!
        @if(session('logged_in'))
            <a href="{{ route('recipes.create') }}">Create your first recipe</a>
        @endif
    </p>
@else
    <table>
        <thead>
            <tr>
                <th>Recipe Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recipes as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td><a href="{{ route('recipes.show', $item) }}">Details</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection