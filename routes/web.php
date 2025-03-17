<?php

use App\Events\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;



Route::get('/about', [UserController::class, "AboutPage"]);
Route::get('/welcome', [UserController::class, "welcomePage"]);

// User related routes
Route::get('/', [UserController::class, "ShowCorrectHomePage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('mustBeLoggedIn');

// Post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{postID}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{postID}', [PostController::class, 'delete'])->middleware('can:delete,postID');
Route::get('/post/{postID}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,postID');
Route::put('/post/{postID}', [PostController::class, 'updateForm'])->middleware('can:update,postID');

// Search related routes
Route::get('/search/{term}', [PostController::class, 'search'])->middleware('mustBeLoggedIn');

// Profile related routes
Route::get('/profile/{userprofile:username}', [UserController::class, 'showProfile']);
Route::get('/profile/{userprofile:username}/followers', [UserController::class, 'showProfileFollowers']);
Route::get('/profile/{userprofile:username}/following', [UserController::class, 'showProfileFollowing']);

// Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('mustBeLoggedIn');

// Chat related routes
Route::post('/send-chat-message', function (Request $request) {
    $formFields = $request->validate([
        'textvalue' => 'required'
    ]);
    if (!trim(strip_tags($formFields['textvalue']))) {
        return response()->noContent();
    }
    broadcast(new ChatMessage([
        'username' => auth()->user()->username,
        'textvalue' => strip_tags($request->textvalue),
        'avatar' => auth()->user()->avatar
    ]))->toOthers();
    return response()->noContent();
})->middleware('mustBeLoggedIn');

// Admin only routes (uses Gates, refer to AppServiceProvier.php)
Route::get('/admins-only', function () {
    // if (Gate::allows('visitAdminPages')){
    //     return 'Only Admins';
    // }
    return 'Admins only';
})->middleware('can:visitAdminPages');