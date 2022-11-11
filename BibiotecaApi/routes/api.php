<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReviewController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::controller(BookReviewController::class)->group(function () {
        Route::post('book-reviews', 'store');
        Route::put('book-reviews/{id}', 'update');
        Route::delete('book-reviews/{id}', 'delete');
    });
});

Route::apiResources([
    'books' => BookController::class,
    'authors' => AuthorController::class,
]);

Route::controller(BookReviewController::class)->group(function () {
    Route::get('book-reviews', 'index');
    Route::get('book-reviews/{id}', 'show');
});
