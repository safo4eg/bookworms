<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RatingController;

Route::controller(Auth::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'login');
    Route::delete('/logout', 'logout');
});

Route::apiResources([
    'authors' => AuthorController::class,
    'books' => BookController::class,
]);

Route::resource('genres', GenreController::class)->except('show');
Route::resource('ratings', RatingController::class)->except(['index', 'show']);
