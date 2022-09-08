<?php

namespace App\Http\Controllers;

// 使用するModels
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;


// 使用するリクエストクラス
use App\Http\Requests\BlogRequest;



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
        $user = \Auth::user();
        return view('profile',['user' => $user]);
    }
       // プロフィール
    public function profileshow($id){
        // $user = \Auth::user();
        $user = User::find($id);
        $items = ['user' => $user,];
        return view('profile', $items);
    }


    // メンバーの一覧
    public function index_member(){

        
        $allusers = User::where('id','!=',\Auth::user()->id)->select('id','name')->get();
        // dd($allusers);

        // Eloquentで紐づいているものを取り出す
        $items = Article::with('user:id,name')->get();
        // $items = Article::where('user_id','!=',\Auth::user()->id)->with('user:id,name')->get();
        // dd($items);

        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
        ->join('tags' , 'tag_id', '=', 'tags.id')
        // ->where('user_id', '!=',\Auth::user()->id)
        ->select('name')
        ->selectRaw('COUNT(name) as count_name')
        ->groupBy('name')
        ->get();

        $days = Article::groupBy('date')
        ->orderBy('date', 'DESC')
        ->get(array(DB::raw('Date(created_at) as date')));

        return view('dashbord_other_user', compact('allusers','items','tags','days'));
    }
    
    // ブログ記事絞り込み(タグの名前)
    public function search($tag_name){
        // クエリビルダ
        $articles = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id', \Auth::id())
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

            $days = Article::groupBy('date')
            ->where('user_id', \Auth::id())
            ->orderBy('date', 'DESC')
            ->get(array(DB::raw('Date(created_at) as date')));
        // dd($days);
        $allusers = User::where('id','!=',\Auth::user()->id)->select('id','name')->get();  

        return view('dashbord', ['articles' => $articles , 'tags' => $tags , 'days' => $days , 'allusers'=>$allusers ]);
    }

    // ブログの絞り込み(time)
    public function search_time($time){
        $article_times = Article::select('articles.*')->leftJoin('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->leftJoin('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id', \Auth::id())
            ->whereBetween('articles.created_at', [$time . ' 00:00:00', $time . ' 23:59:59'])
            // ->where('articles.created_at', $time)
            ->get();
         //dd($article_times);
        // 年月日分秒->年月日にしないといけない

        $days = Article::groupBy('date')
            ->where('user_id', \Auth::id())
            ->orderBy('date', 'DESC')
            ->get(array(DB::raw('Date(created_at) as date')));
        // dd($days);

        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id', \Auth::id())
            ->select('name')
            ->selectRaw('COUNT(name) as count_name')
            ->groupBy('name')
            ->get();
            
        $allusers = User::where('id','!=',\Auth::user()->id)->select('id','name')->get();  
        
        return view('dashbord', ['articles' => $article_times , 'days'=>$days , 'tags' => $tags, 'allusers'=>$allusers]);
    }

        // すべてのユーザーのブログ記事絞り込み
    public function allsearch($tag_name){
        // クエリビルダ
        $articles = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            // ->where('user_id', '!=',\Auth::user()->id)
            // 'tags.name'= $tag_name
            ->where('tags.name', $tag_name)
            ->get();


        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            // ->where('user_id', '!=',\Auth::user()->id)
            ->select('name')
            ->selectRaw('COUNT(name) as count_name')
            ->groupBy('name')
            ->get();

        return view('dashbord_other_tag', ['articles' => $articles , 'tags' => $tags ]);
    }
        // すべてのブログの絞り込み(time)
        public function allsearch_time($time){
            $article_times = Article::select('articles.*')->leftJoin('article_tag', 'article_tag.article_id', '=', 'articles.id')
                ->leftJoin('tags' , 'tag_id', '=', 'tags.id')
                // ->where('user_id')
                ->whereBetween('articles.created_at', [$time . ' 00:00:00', $time . ' 23:59:59'])
                // ->where('articles.created_at', $time)
                ->get();
             //dd($article_times);
            // 年月日分秒->年月日にしないといけない
    
            $days = Article::groupBy('date')
                // ->where('user_id')
                ->orderBy('date', 'DESC')
                ->get(array(DB::raw('Date(created_at) as date')));
            // dd($days);
            
            return view('dashbord_other_time', ['articles' => $article_times , 'days'=>$days ]);
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
            
        $days = Article::groupBy('date')
            ->where('user_id', \Auth::id())
            ->orderBy('date', 'DESC')
            ->get(array(DB::raw('Date(created_at) as date')));

        $allusers = User::where('id','!=',\Auth::user()->id)->select('id','name')->get();

        return view('dashbord', ['articles' => $articles , 'tags' => $tags , 'days'=>$days , 'allusers'=>$allusers ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // ブログ一覧表示画面--->画面あり
    public function index_other($id)
    {

        $user = User::find($id);
        $allusers = User::where('id','!=',\Auth::user()->id)->select('id','name')->get();


        $articles = Article::where('user_id' , $id)
                    ->latest()
                    ->get();
        // $articles = Article::latest()->get();
        // $articles = Article::all();


        $tags = Article::join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags' , 'tag_id', '=', 'tags.id')
            ->where('user_id')
            ->select('name')
            ->selectRaw('COUNT(name) as count_name')
            ->groupBy('name')
            ->get();
            
        $days = Article::groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(DB::raw('Date(created_at) as date')));

        return view('dashbord_other',  ['articles' => $articles , 'tags' => $tags , 'days'=>$days , 'user'=>$user , 'allusers'=>$allusers ] );

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
    public function store(BlogRequest $request)
    {
        var_dump($request->all());
        // 新規記事をarticlesテーブルに入れる処理
        $article = new Article();
        $article->user_id = \Auth::id();
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

        return view('show')->with(['article' => $article,]);
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

        // データが入ってないとエラーがっでる処理
        if (is_null($article)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('show'));
        }

        // 投稿者以外が編集できなくする処理
        if (auth()->user()->id != $article->user_id) {
            return redirect(route('show'))->with('error', '許可されていない操作です');
        }
        
        //tag表示の処理
        $tag_str='';
        foreach($article->tags as $tag){
            $tag_str.=$tag->name . ' ';
        }
        return view('edit', ['article' => $article,'tag_str'=>$tag_str]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 変更処理(editの更新ボタン)--->画面なし
    public function update(BlogRequest  $request, $id)
    {

        // // 投稿者以外が編集できなくする処理
        // if (auth()->user()->id != $article->user_id) {
        //     return redirect(route('show'))->with('error', '許可されていない操作です');
        // }

        // 更新記事をarticlesテーブルに入れる処理（更新）
        $article = Article::find($id);

        // if文で三つ処理を追加
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

        //プロフィール編集フォームを表示する
    public function profileedit($id){

        $users = User::find($id);

        if (is_null($users)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('profile'));
        }
        return view('profileedit',['user' => $users]);
    }

        // プロフィール更新機能
    public function profileupdate(Request $request, $id){

        // 必須項目にする処理
        $this->validate($request, [
            // 'image' => 'required',
            'name' => 'required|max:15',
            'area' => 'required',
            'hobby' => 'required',
            'introduction' => 'required'
        ]);
    
        // 更新記事をarticlesテーブルに入れる処理（更新）
        $users = User::find($id);
        
        // if文で三つ処理を追加
        if ($request->profile_image != null) {
            // dd($request->file('profile_image')->store('public'));
            $users->profile_image =basename( $request->file('profile_image')->store('public'));
        }
        $users->name = $request->name;
        $users->area = $request->area;
        $users->hobby = $request->hobby;
        $users->introduction = $request->introduction;
        // dd($users);
        $users->save();

        // dd($request);
        return redirect(route('profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $article = Article::findOrFail($id);
        // Article::where('id', $id)->delete();

        $article->Delete();
        $article->tags()->detach();

        return redirect('/dashbord');
    }

}

