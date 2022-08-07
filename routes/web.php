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

Route::get('/search/{tag_id}', [App\Http\Controllers\HomeController::class, 'search']);

// 記事詳細画面の表示
Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'show']);


// 足立ルーティング
Route::get('/post_create', [App\Http\Controllers\HomeController::class, 'create'])->name('post_create');
Route::post('/post_insert', [App\Http\Controllers\HomeController::class, 'store'])->name('post_store');

// 倉田ルーティング
//編集画面の表示
Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
//編集登録機能
// Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');

// 松野ルーティング
Route::post('/delete{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');

