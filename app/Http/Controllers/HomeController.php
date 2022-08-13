<?php

namespace App\Http\Controllers;

// 使用するModels
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;

// 使用するDB
use Illuminate\Support\Facades\DB;

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

    // プロフィール
    public function profile(){

        return view('profile');
    }

    // メンバーの一覧
    public function index_member(){

        return view('other_users');
    }

    // ブログ記事絞り込み
    public function search($tag_name){
        // クエリビルダ
        $articles = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            // 'tags.name'= $tag_name
            ->where('tags.name', $tag_name)
            ->get();


        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id', \Auth::id())
            ->select('name')
            ->selectRaw('COUNT(name) as count_name')
            ->groupBy('name')
            ->get();

        return view('dashbord', ['articles' => $articles , 'tags' => $tags]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // ブログ一覧表示画面--->画面あり
    public function index()
    {
        $users=auth()->user();

        $articles = Article::where('user_id' , \Auth::user()->id)
                    ->latest()
                    ->get();
        // $articles = Article::latest()->get();
        // $articles = Article::all();


        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id', \Auth::id())
            ->select('name')
            ->selectRaw('COUNT(name) as count_name')
            ->groupBy('name')
            ->get();
        
        // $tags = DB::table('tags')
        //         ->select('name')
        //         ->selectRaw('COUNT(name) as count_name')
        //         ->groupBy('name')
        //         ->get();

        return view('dashbord', ['articles' => $articles , 'tags' => $tags]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ブログ新規入力フォーム--->画面あり
    public function create(Request $request)
    {
        $users=auth()->user();

        $article = new Article();
        $data_article = ['article' => $article];
        $article->user_id = $request->user()->id;

        $tag = new Tag();
        $data_tag = ['tag' => $tag];

        return view('create' , compact('data_article' , 'data_tag'));
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
        $article->image = $request->file('image')->store('public'); //アップロードした画像ファイルをstorageに保存
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
        // return view('show', ['article' => $article]);
        return view('show')->with([
            'article' => $article,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ブログ編集フォームを表示する--->画面あり
    public function edit($id)
    {
        $article = Article::find($id);
        if (is_null($article)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('show'));
        }

        return view('edit', ['article' => $article]);
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

    //必須項目にする処理
        $this->validate($request, [
        //     'image' => 'required',
            'title' => 'required|max:255',
        //     'tag' => 'required',
            'body' => 'required'
        ]);

        // 更新記事をarticlesテーブルに入れる処理（更新）
        $article = Article::find($id);
        
        // if文で三つ処理を追加
        // if ($request->image != null) {
        //     $article->image = $request->image;
        // }
        $article->user_id = $request->user()->id;
        if ($request->image != null) {
            $article->image = $request->file('image')->store('public');
        }
        $article->title = $request->title;
        $article->body = $request->body;

        $article->save();

        // dd($request);
    
        // 更新タグの名前をtagsテーブルに入れる処理
        $tag = Tag::find($id);
        $tag->name = $request->tag;
        $tag->save();

        // dd($request);

        // 投稿ににタグ付するために、attachメソッドをつかい
        // モデルを結びつけている中間テーブルにレコードを挿入する
        // 中間テーブルではarticle_idとtag_idを結びつける処理を行う
        $article->user_id = $request->user()->id;

        return redirect(route('dashbord'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 削除処理(showの削除ボタン)--->画面なし
   // public function delete($id)
    //{
       // $article = Article::find($id);

        //if (is_null($article)) {
          //  \Session::flash('err_msg', 'データがありません');
            //return redirect(route('dashbord'));
        //}

        

	//try {
	   // ブログを削除

        // $article = Article::destroy($id);
        //} catch(\Throwable $e ){
        //abort(500);		
		//}

    
    public function delete($id){
        $article = Article::findOrFail($id);

        $article->Delete();
        $article->tags()->detach();

        return redirect('/dashbord');
    }

    public function users(){
        $_users =  DB::select('select * from users'); 
        $data = ['users' => $_users];

        return view('other_users', $data);
    }

}

