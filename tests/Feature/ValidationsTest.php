<?php

namespace Tests\Feature;

// Requestファイルを指定する
use App\Http\Requests\BlogRequest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// バリデーション作成
use Illuminate\Support\Facades\Validator;



class ValidationsTest extends TestCase
{
    /**
     * バリデーションテスト
     *
     * @param 項目名
     * @param 値
     * @param 期待値
     *
     * @dataProvider dataprovider
     */

    public function testValidation(string $item, ?string $data, bool $expect): void
    {
        $request  = new BlogRequest();
        // 検証ルールはHomeControllerのstore()
        $rules    = $request->rules();
        // データーの値を連想配列にする
        // $dataList = [$item => $data];
        $dataList = [
            'title' => 'title',
            'tag' => 'tag',
            'body' => 'body',
            'image' => 'image' 
        ];
        $dataList[$item] = $data;
        // dump($dataList);

        // Validator::make('値の配列', '検証ルールの配列');
        $validator = Validator::make($dataList, $rules);
        // dump($validator);

        // true/falseが返る
        $result    = $validator->passes();

        // $expect(true or false) = $result
        // $this->assertEquals($expect, $result);
        $this->assertSame($expect, $result);
    }


    /**
     * データプロバイダ
     *
     * @return データプロバイダ
     *
     * @dataProvider dataprovider
     */

    public function dataprovider(): array
    {
        return [
            'expect_title'   => ['title', 'タイトル名', true],
            'required_title_01' => ['title', null, false],
            'required_title_02' => ['title', '', false],
            'max_title_01'      => ['title', str_repeat('a', 21), false],
            'max_title_02'      => ['title', str_repeat('a', 20), true],

            'expect_tag'   => ['tag', 'タグ名', true],
            'required_tag_01' => ['tag', null, false],
            'required_tag_02' => ['tag', '', false],
            'max_tag_01'      => ['tag', str_repeat('a', 16), false],
            'max_tag_02'      => ['tag', str_repeat('a', 15), true],

            'expect_body'   => ['body', '本文', true],
            'required_body_01' => ['body', null, false],
            'required_body_02' => ['body', '', false],
            'max_body_01'      => ['body', str_repeat('a', 26), false],
            'max_body_02'      => ['body', str_repeat('a', 25), true],

            'required_image_01' => ['image', null, false],
            'required_image_02' => ['image', '', false],
            // 'max_image_01'      => ['image', filesize(1025), false],
            // 'max_image_02'      => ['image', filesize(1024), true],
        ];
    }
}
