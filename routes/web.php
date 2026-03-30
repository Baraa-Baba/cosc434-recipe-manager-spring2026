<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Tag;

// Home redirect
Route::get('/', function () {
    return redirect()->route('recipes.index');
});

// Simulate authentication via session
Route::get('/login-demo', function (Request $request) {
    $request->session()->put('logged_in', true);
    return redirect('/recipes')->with('success', 'Welcome! Demo session started.');
});

Route::get('/logout-demo', function (Request $request) {
    $request->session()->flush();
    return redirect('/recipes')->with('success', 'Goodbye! Demo session ended.');
});

// Public-facing recipe routes (anyone can view)
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Guarded recipe management routes (demo login required)
Route::middleware('demo.auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// API Demo Page (Lab 8)
Route::get('/recipes-api-demo', function () {
    return view('recipes.api-demo', [
        'categories' => Category::all(),
        'tags' => Tag::all(),
    ]);
});