<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

Route::resource('recipes', RecipeController::class);



Route::middleware(a,b,c)->group(function(){
route1,
route2
route3->withoutc

})