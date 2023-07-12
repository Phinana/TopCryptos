<?php

use App\Http\Controllers\Admin\BlogAnswerController as AdminBlogAnswerController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\BlogAnswerController as UserBlogAnswerController;
use App\Http\Controllers\User\BlogController as UserBlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register'])->name('register');
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::group([
    'middleware' => [
        'auth:sanctum',
    ],
], function () {

    Route::group([
        'prefix' => 'admin',
        'middleware' => [
            'admin-access',
        ],
    ], function () {

        Route::get('/blogs', [AdminBlogController::class, 'index']);
        Route::get('/blogs/{blog}', [AdminBlogController::class, 'show']);
        Route::post('/blogs', [AdminBlogController::class, 'store']);
        Route::put('/blogs/{blog}', [AdminBlogController::class, 'update']);
        Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy']);

        Route::get('/blog-answers', [AdminBlogAnswerController::class, 'index']);
        Route::post('/blogs/{blog}/blog-answers', [AdminBlogAnswerController::class, 'store']);
        Route::delete('/blog-answers/{blogAnswer}', [AdminBlogAnswerController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::get('/blog-answers', [UserBlogAnswerController::class, 'index']);
        Route::post('/blogs/{blog}/blog-answers', [UserBlogAnswerController::class, 'store']);
        Route::delete('/blog-answers/{blogAnswer}', [UserBlogAnswerController::class, 'destroy']);

        Route::get('/blogs', [UserBlogController::class, 'index']);
        Route::post('/blogs', [UserBlogController::class, 'store']);
        Route::get('/blogs/{blog}', [UserBlogController::class, 'show']);
        Route::put('/blogs/{blog}', [UserBlogController::class, 'update']);
        Route::delete('/blogs/{blog}', [UserBlogController::class, 'destroy']);
    });

    Route::delete('auth/logout', [AuthController::class, 'logout'])->name('logout');
});
