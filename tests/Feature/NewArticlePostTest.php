<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class NewArticlePostTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        // テストの定義(共通なもの)
        parent::setUp();                   
        // factoryを使用してテストユーザ作成
        $this->user = User::factory()->create(); 
        // {モデル名}::factory()->create();
    }

    /**
     * 5.新規投稿画面 No.5
     * 新規ブログフォームに以下の内容を入力し、投稿するボタンを押下する
     * ・画像：あり
     * ・タイトル：レクサス
     * ・タグ：車
     * ・本文：新規ブログ作成画面からの投稿です
     * @return void
     */
    public function test_example5_5()
    {
        //ダミーユーザーを作成する
        $user = User::factory()->create();

        //ダミーユーザーでログイン
        $this->actingAs($user)
                ->get('/post_create');

        $this->withoutExceptionHandling();

        Storage::fake(); 
        $file = UploadedFile::fake()->image('avatar.jpg');                     
        $response = $this->withoutMiddleware()->json('POST', '/post_insert' ,[
            'image' => $file,
            'title' => 'レクサス',
            'tag' => '車',
            'body' => '新規ブログ作成画面からの投稿です',
            ]);
        // publicにファイルが保存されているか
        Storage::disk()->assertExists('public/' . $file->hashName()); // ❌Storage::disk('public')
        $response->assertRedirect('/dashbord');
    }

    /**
     * 5.新規投稿画面 No.6
     * 新規ブログフォームに以下の内容を入力し、投稿するボタンを押下する
     * ・画像：空
     * ・タイトル：レクサス
     * ・タグ：車
     * ・本文：新規ブログ作成画面からの投稿です
     * @return void
     */
    public function test_example5_6()
    {
        //ダミーユーザーを作成する
        $user = User::factory()->create();

        //ダミーユーザーでログイン
        $this->actingAs($user)
                ->get('/post_create');

        $this->withoutExceptionHandling();

        Storage::fake(); 
        $file = UploadedFile::fake()->image('avatar.jpg');                     
        $response = $this->withoutMiddleware()->json('POST', '/post_insert' ,[
            'image' => $file,
            'title' => 'レクサス',
            'tag' => '車',
            'body' => '新規ブログ作成画面からの投稿です',
            ]);
        // publicにファイルが保存されているか
        Storage::disk()->assertExists('public/' . $file->hashName()); 
        $response->assertRedirect('/dashbord');
    }

    /**
     * 5.新規投稿画面 No.7
     * 新規ブログフォームに以下の内容を入力し、投稿するボタンを押下する
     * ・画像：あり
     * ・タイトル：空
     * ・タグ：車
     * ・本文：新規ブログ作成画面からの投稿です
     * @return void
     */
    public function test_example5_7()
    {
        //ダミーユーザーを作成する
        $user = User::factory()->create();

        //ダミーユーザーでログイン
        $this->actingAs($user)
                ->get('/post_create');

        // 新規投稿でタイトルがnullの場合バリデーションが返される
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.jpg');                     
        $response= $this->postJson('/post_insert' ,[
            'image' => $file,
            'title' => '',
            'tag' => '車',
            'body' => '新規ブログ作成画面からの投稿です',
        ]);
        $response->assertStatus(422);
    }

    /**
     * 5.新規投稿画面 No.8
     * 新規ブログフォームに以下の内容を入力し、投稿するボタンを押下する
     * ・画像：あり
     * ・タイトル：レクサス
     * ・タグ：空
     * ・本文：新規ブログ作成画面からの投稿です
     * @return void
     */
    public function test_example5_8()
    {
        //ダミーユーザーを作成する
        $user = User::factory()->create();

        //ダミーユーザーでログイン
        $this->actingAs($user)
                ->get('/post_create');

        // 新規投稿でタイトルがnullの場合バリデーションが返される
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.jpg');                     
        $response= $this->postJson('/post_insert' ,[
            'image' => $file,
            'title' => 'レクサス',
            'tag' => '',
            'body' => '新規ブログ作成画面からの投稿です',
        ]);
        $response->assertStatus(422);
    }

    /**
     * 5.新規投稿画面 No.9
     * 新規ブログフォームに以下の内容を入力し、投稿するボタンを押下する
     * ・画像：あり
     * ・タイトル：レクサス
     * ・タグ：空
     * ・本文：新規ブログ作成画面からの投稿です
     * @return void
     */
    public function test_example5_9()
    {
        //ダミーユーザーを作成する
        $user = User::factory()->create();

        //ダミーユーザーでログイン
        $this->actingAs($user)
                ->get('/post_create');

        // 新規投稿でタイトルがnullの場合バリデーションが返される
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.jpg');                     
        $response= $this->postJson('/post_insert' ,[
            'image' => $file,
            'title' => 'レクサス',
            'tag' => '車',
            'body' => '',
        ]);
        $response->assertStatus(422);
    }
}
