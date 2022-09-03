<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\UploadedFile;

class CRUDfunctionTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
    parent::setUp();
    // テストユーザ作成
    $this->user = User::factory()->create();
    // 他のテストユーザ作成
    $this->another_user = User::factory()->create();
    // テストユーザーの記事作成
    $this->article = Article::factory()->create(['user_id' => $this->user->id]);

    // dd($this->article);
    $tag = Tag::factory()->create(['name' => 'some-tag']);
    $this->article->tags()->attach($tag->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_ログインしていれば投稿・一覧に表示することが出来る() {

    // ユーザーをログイン状態にして、投稿ページに遷移させる
    $response = $this->actingAs($this->user)->get(route('post_create'));
    // 投稿ページのステータステストを行う
    $response->assertStatus(200);
    // 遷移先が投稿ページ確認する
    $response->assertViewIs('create');

    // 投稿する値を定義します
    $file = UploadedFile::fake()->image('avatar.jpg');
    $article_data = [
        'title' => 'タイトル',
        'tag' => 'タグ',
        'body' => '本文',
        'image' => $file
    ];

    // routeメソッドでコントローラー側にpostアクションとして飛ばします。
    $url = route('post_store');
    $response = $this->post($url, $article_data);

    // 投稿がうまくいけばエラーメッセージがないことを確認する
    $response->assertSessionHasNoErrors(); 

    // リダイレクト
    $response->assertStatus(302); 

    // 投稿した後はリダイレクトで画面に戻って来ているか確認する。
    $response->assertRedirect('/dashbord'); 

    // 保存したitemがデータベースに存在するか確認。
    $this->assertDatabaseHas('articles', ['title' => 'タイトル']);

    // ボタンがあるか確認する
    $response = $this->get('/dashbord');
    $response->assertStatus(200);
    $response->assertSeeText('ブログ一覧(全て)');

    // 一覧ページに移動
    $response = $this->get(route('dashbord'));
    $response->assertStatus(200);

    // 一覧ページが表示されているか確認
    $response->assertViewIs('dashbord');

    // 先ほど投稿したitemのtitleと一致するものが表示されているか
    $response->assertSeeText($article_data['title']);
    }


    public function test_ログインしているかつ、自分の投稿であれば編集出来る(){
    
    // ユーザーをログイン状態にする
    $response = $this->actingAs($this->user);
    // メゾットで作成したarticleの編集ページにアクセスし、ステータステストを行う
    $response = $this->get(route('edit', $this->article->id));
    $response->assertStatus(200);

    //(1)編集する値を定義する
    $file = UploadedFile::fake()->image('avatar.jpg');
    $article_data = [
        'title' => 'タイトル(編集成功)',
        'tag' => 'タグ(編集成功)',
        'body' => '本文(編集成功)',
        'image' => $file
    ];

    //(2)updateアクションを動かすためのルートを設定、定義する
    $update_url = route('update', $this->article->id);

    // putメソッドで(1),(2)の情報を持ってupdate処理に飛ばしています。
    $response = $this->post($update_url, $article_data);

    // エラーメッセージがないこと
    $response->assertSessionHasNoErrors(); 

    // リダイレクト
    $response->assertStatus(302); 

    // リダイレクトした時のurlリンク
    $response->assertRedirect('/dashbord', $this->article->id); 

    // 編集したレコードが存在するか
    $this->assertDatabaseHas('articles', ['title' => 'タイトル(編集成功)']);
    } 


    public function test_ログインしているかつ、自分の投稿であれば削除出来る() 
    {

    // showページにアクセスした時にボタンが存在していること == 自分の投稿&ログインしている。

    // ユーザーをログイン状態にする
    $response = $this->actingAs($this->user);
    // 詳細ページにアクセスする
    $response = $this->get(route('show', $this->article->id ));
    // dd($this->user);
    // 詳細ページにアクセスでき、編集・削除ボタンが存在していることを確認する
    $response->assertSee('編集', '削除');
    $response->assertStatus(200);

    // 削除する前にDBに存在するか確認
    $this->assertDatabaseHas('articles',  ['id' => $this->article->id]);

    //(1)deleteアクションに飛ばすためにパスをrouteメゾットを使用して定義する
    $delete_url = route('delete', ['id' => $this->article->id]);
    //(1)で定義したものをcontroller側に飛ばす
    // $response = $this->delete($delete_url);
    $response = $this->post($delete_url);
    $response->assertSessionHasNoErrors(); 

    // 削除された後は一覧ページに遷移しているか確認する
    $response = $this->get('/dashbord');
    $response->assertStatus(200);

    // assertDeletedメソッドでarticleが削除されている事を確認します。
    $this->assertDeleted($this->article);

    // 削除したitemがデータベースに存在しないことを確認します
    // $this->assertDatabaseMissing('articles', $this->article->id);
    $this->assertDatabaseMissing('articles',  ['id' => $this->article->id]);
    }


}