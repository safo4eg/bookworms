<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(Auth::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'login');
    Route::delete('/logout', 'logout');
});

Route::apiResources([
    'authors' => AuthorController::class,
    'books' => BookController::class
]);
