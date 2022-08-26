<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     * ログインしていない時のステータス
     * @return void
     */
    public function testIndexStatus()
    {
        $response=$this->get('/');
        $response->assertStatus(200);   //リクエストが成功し正常に情報が返される

        $response=$this->get('/dashbord');
        $response->assertStatus(302);

        $response=$this->get('/search/{tag_id}');
        $response->assertStatus(302);

        $response=$this->get('/show/{id}');
        $response->assertStatus(302);

        $response=$this->get('/post_create');
        $response->assertStatus(302);   //一時的な移転

        $response=$this->get('/post_insert');
        $response->assertStatus(405);   //許可されていないメソッドを使用しようとした場合

        $response=$this->get('/edit/{id}');
        $response->assertStatus(302);

        $response=$this->get('/update/{id}');
        $response->assertStatus(405);

        $response=$this->get('/profileedit/{id}');
        $response->assertStatus(302);

        $response=$this->get('/profileupdate/{id}');
        $response->assertStatus(405);

        $response=$this->get('/delete/{id}');
        $response->assertStatus(405);

    }
}
