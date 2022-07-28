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
Route::get('/dashbord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');


// 足立ルーティング
Route::get('/post_create', [App\Http\Controllers\HomeController::class, 'create'])->name('post_create');


// 倉田ルーティング


// 松野ルーティング
Route::post('/delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');