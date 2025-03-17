<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'loginApi']);
Route::post('/create-post', [PostController::class, 'storeNewPostApi'])->middleware('auth:sanctum');
Route::delete('/delete-post/{postID}',[PostController::class, 'deletePostApi'])->middleware('auth:sanctum', 'can:delete,postID');