<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexStatus()
    {
        $response=$this->get('/');
        $response->assertStatus(200);

        $response=$this->get('/dashbord');
        $response->assertStatus(302);

        $response=$this->get('/search/{tag_id}');
        $response->assertStatus(302);
    }
}
