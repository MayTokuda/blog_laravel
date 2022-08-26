<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        // factoryを利用
        // {モデル名}::factory()->create();
        Article::factory()
            ->create()
            ->each(function (Article $article) use ($tags) {
                //1~6までの数値をランダムで取得
                $ran = rand(1, 6);

                // 中間テーブルに紐付け
                $article->tags()->attach(
                    //tagsテーブルからランダムで1~6個のインスタンスを紐づける。
                    // $tags->random($ran)->pluck('id')->toArray(),
                   //attachの第二引数は他のカラムに挿入したい値を入れることができる。
                   //今回はtag_numberというカラムにランダムで1~6の数値を挿入。これは僕の都合上やってるだけなので、気にしなくてOK。
                    ['tag_id'=>$ran] 
                );
            });
    }
}
