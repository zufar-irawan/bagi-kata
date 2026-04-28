<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'home']);

Route::get('/new', function () {
    return view('posts.create_post');
});

Route::get('/post/{id}', [PostController::class, 'detailPost']);

Route::get('/post/{id}/update', [PostController::class, 'updateView']);
Route::delete('/post/{id}', [PostController::class, 'deletePost']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/me', [ProfileController::class, 'index']);
Route::get('/profile/{id}', [ProfileController::class, 'show']);

Route::get('/me/edit', [ProfileController::class, 'editView']);

Route::get('/favorit', [ProfileController::class, 'favoriteView']);
