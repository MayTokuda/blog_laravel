<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterPostTest extends TestCase
{
    /**
     * A basic test example.
     *2. 会員登録画面 No.2
     * @return void
     */
    public function test_example1()
    {
        // '/'のレスポンスは200か
        $response = $this->get('/')->assertStatus(200);
        // '/register'のレスポンスは200か
        $response = $this->get('/register')->assertOk();
        // '/hoge'にアクセスすると404か
        $response = $this->get('/hoge')->assertStatus(404);
        // '/register'内にテキストで'ニックネーム','メールアドレス','パスワード','パスワード（確認用）'という値はあるか
        $response = $this->get('/register')->assertSeeText('ニックネーム','メールアドレス','パスワード','パスワード（確認用）');
        // '/register'内にhtmlタグで form はあるか
        $response = $this->get('/register')->assertSee('form');
        // '/register'内にhtmlタグで button はあるか
        $response = $this->get('/register')->assertSee('button');
        // ログインのリンクはあるか
        $response = $this->get('/login');
    }
    /**
     * A basic test example.
     * 2.会員登録画面 No.6
     * 会員登録画面を表示し、以下のユーザーで会員登録する
     * ・ユーザー名：taro_new
     * ・メールアドレス：test_new.com
     * ・パスワード：password
     * @return void
     */
    public function test_example2_6()
    {
        // '/register'で新規登録したら値が送信されるか
        $response = $this->post('/register',[    
        'name' => 'taro_new',
        'email' => 'test_new@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ]);
        // 新規登録ができたら /login にリダイレクトされるか
        $response->assertRedirect('/login');
    }

    /**
     * 2. 会員登録画面 No.7
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：空
　　　* ・メールアドレス：空
     * ・パスワード：空
     * @return void
     */
    public function test_example2_7()
    {
        // '/register'で名前、メールアドレス、パスワードがnullの場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.8
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：空
　　　* ・メールアドレス：test_new2@example.com
     * ・パスワード：password
     * @return void
     */
    public function test_example2_8()
    {
        // '/register'で名前がnullの場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => '',
        'email' => 'test_new2@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.９
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：taro_new2
　　　* ・メールアドレス：空
     * ・パスワード：password
     * @return void
     */
    public function test_example2_9()
    {
        // '/register'でメールアドレスがnullの場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => 'taro_new2',
        'email' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.10
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：taro_new2
　　　* ・メールアドレス：test_new2@example.com
     * ・パスワード：空
     * @return void
     */
    public function test_example2_10()
    {
        // '/register'でパスワードがnullの場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => 'taro_new2',
        'email' => 'test_new2@example.com',
        'password' => '',
        'password_confirmation' => '',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.11
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：taro_new2
　　　* ・メールアドレス：test_new2@example.com
     * ・パスワード：pas
     * @return void
     */
    public function test_example2_11()
    {
        // '/register'でパスワードが文字不足の場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => 'taro_new2',
        'email' => 'test_new2@example.com',
        'password' => 'pas',
        'password_confirmation' => 'pas',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.12
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：taro_new2
　　　* ・メールアドレス：test_new2@
     * ・パスワード：password
     * @return void
     */
    public function test_example2_12()
    {
        // '/register'でメールアドレスが正しくない場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => 'taro_new2',
        'email' => 'test_new2@',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }

    /**
     * 2. 会員登録画面 No.13
     * 会員登録画面を表示し、以下のユーザーで会員登録する(異常値)
     * ・ユーザー名：taro_new2
　　　* ・メールアドレス：test_new2@example.com
     * ・パスワード：password
     * ・確認用パスワード：password2
     * @return void
     */
    public function test_example2_13()
    {
        // '/register'でパスワードが不一致の場合バリデーションが返される
        $response = $this->postJson('/register',[    
        'name' => 'taro_new2',
        'email' => 'test_new2@example.com',
        'password' => 'password',
        'password_confirmation' => 'password2',
        'remember_token' => '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW'
        ])->assertStatus(422);
    }   
}