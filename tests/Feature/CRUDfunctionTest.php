<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
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
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログインしていれば投稿出来る() {

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
}
