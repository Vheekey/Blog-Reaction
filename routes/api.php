<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest.token')->group(function(){

    Route::prefix('posts')->controller(PostController::class)->group(function(){
        Route::get('/user', 'getUserPosts');
        Route::post('/', 'create');
        Route::get('/{post}', 'getSinglePost');
        Route::put('/{post}', 'update');
        Route::delete('/{post}', 'delete');
    });

    Route::prefix('comments')->controller(CommentController::class)->group(function(){
        Route::post('/{post}', 'create');
        Route::get('/{comment}', 'getCommentsWithReactions');
        Route::get('/{post}', 'getPostCommentsWithReactions');
        Route::put('/{post}', 'update');
        Route::delete('/{post}', 'delete');
    });

    Route::prefix('comments')->controller(ReactionController::class)->group(function(){
        Route::put('/{comment}/add-reaction', 'addReaction');
        Route::delete('/{comment}/remove-reaction', 'removeReaction');
    });

});

