<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
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
    * A basic feature test example.
    *
    * @return void
    */
    public function test_正しいパスワードの場合()
    {
        // ログイン画面に遷移する
        $response = $this->get('/login');
        // ログイン画面のステータステストを行う
        $response->assertStatus(200);

        // ログインする(postメゾットでルートで飛ばす先を設定、emailとpasswordを書いてログインアクションに飛ばす)
        $response = $this->post(route('login'), ['email' => $this->user->email, 'password' => 'password']);

        // ログインできたらリダイレクトでページ遷移してくるのでstatusは302
        $response->assertStatus(302);
        // リダイレクトで帰ってきた時のパス
        $response->assertRedirect('/dashbord');

        // このユーザーがログイン認証されているか
        $this->assertAuthenticatedAs($this->user);
    }
}
