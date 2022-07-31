<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

// 徳田ルーティング
// 記事一覧画面の表示
Route::get('/dashbord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');
// 記事詳細画面の表示
Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'show']);


Route::get('/post_create', [App\Http\Controllers\HomeController::class, 'create'])->name('post_create');

// 倉田ルーティング


// 松野ルーティング
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

