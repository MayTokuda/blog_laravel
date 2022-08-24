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


    public function test_間違ったパスワードの場合()
    {
        // ログイン画面に遷移する
        $response = $this->get('/login');
        // ログイン画面のステータステストを行う
        $response->assertStatus(200);

        // パスワードが正しく無い状態でログイン
        $response = $this->post('/login', ['email' => $this->user->email, 'password' => 'Test123']);
        // リダイレクトで戻ってくる。
        $response->assertStatus(302);
        // リダイレクトで戻ってきた時はログインページにいる事
        $response->assertRedirect('/login');
        // 失敗しているので認証されていない事
        $this->assertGuest();
    }


    public function test_ログアウトが正しくできるか()
    {
        // ログイン状態の作成
        // テスト側でユーザーの認証状態を指定
        $response = $this->actingAs($this->user);
        // ログアウトボタンが存在するところに戻る
        $response = $this->get('/dashbord');
        // ステータステストを行う
        $response->assertStatus(200);

        // ログアウト処理をする(postアクションでログアウトに処理を飛ばす)
        $this->post('logout');

        // ログアウト出来たら200番が帰ってきているか
        $response->assertStatus(200);

        // ログインページにいる事
        $response = $this->get('/login');
        // ログイン画面のステータステストを行う
        $response->assertStatus(200);

        // 認証されていないことを確認
        $this->assertGuest();
    }


    public function test_ログインしていれば登録ページに遷移できない()
    {
        // ユーザーをログイン状態にします。
        $response = $this->actingAs($this->user);

        // 登録ページにアクセスする
        $response = $this->get('/register');

        // 登録画面のステータステストを行う
        // 登録した状態にあるので、跳ね返されます。ページは存在するけどアクセスする権限が無いので302をステータスで期待します
        $response->assertStatus(302);
    }


    public function test_Emailが重複していれば登録できない()
    {
        // 登録ページにアクセスする
        $response = $this->get('/register');

        // 登録画面のステータステストを行う
        $response->assertStatus(200);

        // $passwordのハッシュ化を行う
        $password = bcrypt('password');
        $user_data = [
            'name' => '太郎',
            //  emailを既に登録しているユーザーのものと同じものにする。(重複テスト)
            'email' => $this->user->email,
            // メールアドレスが確認された日時を格納
            'email_verified_at' => now(),
            // パスワード
            'password' => $password,
            // 確認パスワードも必要
            'password_confirmation' => $password,
            // 'remember_token'=ログイン状態を保持させる---ランダムな文字列を生成する
            'remember_token' => \Str::random(10),
        ];
        // ログイン後に飛ばすアクションを定義する->ログイン認証を行うところ
        $first_path = route('login');

        // 設定したパス情報と、登録情報を持ってpostアクションでコントローラー処理に飛ばす。
        $response = $this->post($first_path, $user_data);

        // 跳ね返されて、求めているエラーメッセージがsessionに含まれているか確認する(assertSeeは効かない可能性がある)
        $response->assertSessionHasErrorsIn("もうすでに登録されています"); 

        // ページは存在するけどアクセスする権限が無いので302をステータスで期待します
        $response->assertStatus(302);

        // リダイレクトで登録ページ遷移している事
        $response->assertRedirect(route('register'));
    }


    public function test_Passwordが8文字以下であれば登録できない()
    {
        // 登録ページにアクセスする
        $response = $this->get('/register');

        // 登録画面のステータステストを行う
        $response->assertStatus(200);

        // パスワードを1文字にする
        $password = 'T';
        $user_data = [
            'name' => '太郎',
            'email' => 'test@test',
            'email_verified_at' => now(),
            // パスワードは1文字('T')
            'password' => $password,
            // 確認パスワードも必要
            'password_confirmation' => $password,
            'remember_token' => \Str::random(10),
        ];
        // ログイン後に飛ばすアクションを定義する->ログイン認証を行うところ
        $first_path = route('login');

        // 設定したパス情報と、登録情報を持ってpostアクションでコントローラー処理に飛ばす。
        $response = $this->post($first_path, $user_data);

        // リダイレクトで跳ね返って来た時に求めているエラーメッセージがsessionに含まれているか確認します
        $response->assertSessionHasErrorsIn("パスワードは8文字以上で入力してください");

        // ページは存在するけどアクセスする権限が無いので302をステータスで期待します
        $response->assertStatus(302);

        // リダイレクトでページ遷移している事
        $response->assertRedirect(route('register'));

    }
}
