<?php

use App\Http\Controllers\API\CategoryRestController;
use App\Http\Controllers\API\ImageRestController;
use App\Http\Controllers\API\PostRestController;
use App\Http\Controllers\API\UserRestController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', [UserRestController::class, 'createUser']);

Route::group(['prefix' => 'categories'], function() {
    Route::get('/', [CategoryRestController::class, 'getAllCategories']);
    Route::get('/{id}', [CategoryRestController::class, 'getCategoryById']);
    Route::post('/', [CategoryRestController::class, 'createCategory']);
});

Route::group(['prefix' => 'posts'], function() {
    Route::get('/', [PostRestController::class, 'getAllPosts']);
    Route::get('/paging', [PostRestController::class, 'getPostByPagination']);
    Route::get('/{id}', [PostRestController::class, 'getPostById']);
    Route::delete('/{id}', [PostRestController::class, 'deletePostById']);
    Route::post('/', [PostRestController::class, 'createPost']);
    Route::post('/image/store', [ImageRestController::class, 'storeImage']);
});
