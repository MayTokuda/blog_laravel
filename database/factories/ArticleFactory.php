<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    // ファクトリークラスと紐づいているモデルクラスを定義する
    protected $model = Article::class;

    public function definition()
    {
        return [
            // ユーザーのid
            'user_id' => function() {return User::factory()->create()->id;},

            // 記事の画像
            'image' => $this->faker->image(),

            // 記事のタイトル-20文字
            'title' => $this->faker->sentence(20),

            // 記事のタグ-15文字---articleテーブル=>article_tagテーブル=>tagテーブル
            // 'tag_name' => function() {return Tag::factory()->create()->name;},

            // 'tag_name' => Article::factory()
            //                 ->has(ArticleTag::factory()->state())->create();

            // 参考コード
            // $user = User::factory()->has(
            //     Post::factory(3)
            //         ->state(
            //         function(array $attributes, User $user) {
            //             return ['user_type' => $user->type];
            //         })
            // )->create();

            // 記事の本文-25文字
            'body' => $this->faker->sentence(25),
        ];
    }
}
