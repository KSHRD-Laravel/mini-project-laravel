<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthFacebookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts/{id}', function ($id) {
    return view('posts.view', ["id" => $id]);
});

Route::get('/categories/{id}', function ($id) {
    return view('category.view', ["id" => $id]);
});

Route::get('/post/create', function () {
    return view('posts.create');
});

Route::get('/category/create', function () {
    return view('category.create');
});


Route::get('/redirect', [SocialAuthFacebookController::class, 'redirect']);
Route::get('/callback', [SocialAuthFacebookController::class, 'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
