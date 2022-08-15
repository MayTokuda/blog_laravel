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

    public function testValidation(string $item, string $data, bool $expect): void
    {
        $request  = new BlogRequest();
        // 検証ルールはHomeControllerのstore()
        $rules    = $request->rules();
        // データーの値を連想配列にする
        $dataList = [$item => $data];

        // Validator::make('値の配列', '検証ルールの配列');
        $validator = Validator::make($dataList, $rules);

        $result    = $validator->passes();

        // $expect(true or false) = $result
        $this->assertEquals($expect, $result);
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
            'expect'   => ['title', 'タイトル名', true],
            'required' => ['title', null, false],
            'required' => ['title', '', false],
            'max'      => ['title', str_repeat('a', 51), false],
            'max'      => ['title', str_repeat('a', 50), true],
        ];
    }
}
