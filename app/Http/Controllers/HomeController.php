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
        $articles = Article::latest()->get();
        // $articles = Article::all();

        return view('dashbord', ['articles' => $articles]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ブログ新規入力フォーム--->画面あり
    public function create()
    {
        $article = new Article();
        $data_article = ['article' => $article];

        $tag = new Tag();
        $data_tag = ['tag' => $tag];

        return view('create' , compact($data_article , $data_tag));
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
        $this->validate($request, [
            'image' => 'required',
            'title' => 'required|max:255',
            'tag' => 'required',
            'body' => 'required'
        ]);

        // 新規記事をarticlesテーブルに入れる処理
        $article = new Article();
        $article->user_id = $request->user()->id;
        $article->image = $request->image;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();
    
        // 新規タグの名前をtagsテーブルに入れる処理
        $tag = new Tag();
        $tag->name = $request->tag;
        $tag->save();

        // 投稿ににタグ付するために、attachメソッドをつかい
        // モデルを結びつけている中間テーブルにレコードを挿入する
        // 中間テーブルではarticle_idとtag_idを結びつける処理を行う
        $article->tags()->attach($tag->id);

        return redirect(route('dashbord'));
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
        $article = Article::find($id);

        if (is_null($article)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('show'));
        }
        return view('show', ['article' => $article]);
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
