<?php

namespace App\Http\Controllers;

// 使用するModels
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // ブログ一覧表示画面--->画面あり
    public function index()
    {
        return view('dashbord');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ブログ新規入力フォーム--->画面あり
    public function create()
    {
        return view('create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 追加処理(createの登録ボタン)--->画面なし
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ブログ詳細表示--->画面あり
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 変更フォーム(既存の値が入っている状態)--->画面あり
    public function edit($id)
    {
        // 
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 変更処理(editの更新ボタン)--->画面なし
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 削除処理(showの削除ボタン)--->画面なし
    public function destroy($id)
    {
        //
    }
}
