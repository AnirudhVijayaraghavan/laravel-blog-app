<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;



Route::get('/about', [UserController::class, "AboutPage"]);
Route::get('/welcome', [UserController::class, "welcomePage"]);

// User related routes
Route::get('/', [UserController::class, "ShowCorrectHomePage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');

// Post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{postID}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{postID}', [PostController::class, 'delete']);

// Profile related routes
Route::get('/profile/{userprofile:username}', [UserController::class, 'showProfile']);