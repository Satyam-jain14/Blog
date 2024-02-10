<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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
    return view('auth.login');
});

Auth::routes();
Route::resource('blog', BlogController::class);
Route::resource('comment', CommentController::class);
Route::resource('like', LikeController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/editProfile',[UserController::class,'editProfile']);
Route::post('/userProfile',[UserController::class,'userProfile']);
Route::get('/userProfile/{id}',[UserController::class,'show']);
Route::patch('/user/update/{id}',[UserController::class,'updateProfile']);

