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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('top');
});

Auth::routes();

//プロフィール画面を表示
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

//他のユーザのプロフィールを表示
Route::get('/profile/{user}', [App\Http\Controllers\HomeController::class, 'profileshow']);
//他のユーザのブログを表示
Route::get('/dashbord_other/{user}', [App\Http\Controllers\HomeController::class, 'index_other']);

// 登録したユーザーの名前
Route::get('/other_users', [App\Http\Controllers\HomeController::class, 'index_member'])->name('other_users');
// 登録したユーザーのブログ一覧表示
Route::get('/dashbord2/{user_id}', [App\Http\Controllers\HomeController::class, 'user'])->name('dashbord2');


// 記事一覧画面の表示
Route::get('/dashbord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');

// 記事絞り込み機能(タグ)
Route::get('/search/{tag_id}', [App\Http\Controllers\HomeController::class, 'search']);
Route::get('/wordsearch', [App\Http\Controllers\HomeController::class, 'search']);
// 他ユーザー記事絞り込み機能(タグ)
Route::get('/allsearch/{tag_id}', [App\Http\Controllers\HomeController::class, 'allsearch']);


// 記事絞り込み機能(time)
Route::get('/search_time/{time}', [App\Http\Controllers\HomeController::class, 'search_time']);
Route::get('/allsearch_time/{time}', [App\Http\Controllers\HomeController::class, 'allsearch_time']);

// 記事詳細画面の表示
Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('show');


//ブログ新規登録画面の表示
Route::get('/post_create', [App\Http\Controllers\HomeController::class, 'create'])->name('post_create');
//ブログ新規登録機能
Route::post('/post_insert', [App\Http\Controllers\HomeController::class, 'store'])->name('post_store');
//編集画面の表示
Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
//編集機能
Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
// 記事削除機能
Route::post('/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');


// プロフィール編集画面の表示
Route::get('/profileedit/{id}', [App\Http\Controllers\HomeController::class, 'profileedit'])->name('profileedit_get');
Route::post('/profileedit/{id}', [App\Http\Controllers\HomeController::class, 'profileedit'])->name('profileedit');
// プロフィール編集機能
Route::post('/profileupdate/{id}', [App\Http\Controllers\HomeController::class, 'profileupdate'])->name('profileupdate');


