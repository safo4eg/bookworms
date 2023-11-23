<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;

Route::controller(Auth::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'login');
    Route::delete('/logout', 'logout');
});

Route::apiResources([
    'authors' => AuthorController::class,
    'books' => BookController::class,
]);

Route::apiResource('genres', GenreController::class)->except('show');
Route::apiResource('books.ratings', RatingController::class)
    ->except(['index', 'show'])
    ->shallow();
Route::apiResource('books.reviews', ReviewController::class)
    ->shallow();
