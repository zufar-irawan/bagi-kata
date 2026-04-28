<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'home']);

Route::get('/new', [PostController::class, 'createView']);
Route::post('/new/creating', [PostController::class, 'createPost']);

Route::get('/post/{id}', [PostController::class, 'detailPost']);

Route::get('/post/{id}/update', [PostController::class, 'updateView']);
Route::put('/post/{id}/updating', [PostController::class, 'updatePost']);
Route::delete('/post/{id}', [PostController::class, 'deletePost']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
