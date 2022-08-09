<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ArticleTag;

class Article extends Model
{
    
    use HasFactory;

    // Articleモデル(子)
    // 
    // usersテーブル(親)とarticlesテーブル(子)のリレーション
    
    public function user(){
        return $this -> belongsTo('App\Models\User');
    }   


    // Articleモデル(親)
    // 
    // articlesテーブル(親)とtagsテーブル(子)のリレーション
    // 多対多のリレーション
    
    public function tags(){
        return $this -> belongsToMany('App\Models\Tag');
    }   

    public static function boot(){
        parent::boot();

        static::deleting(function ($article){

            $article->tags()->delete();
        });
    }

    // Articleモデル(親)
    // 
    // articlesテーブル(親)とcommentsテーブル(子)のリレーション
    
    public function comments(){
        return $this -> hasMany('App\Models\Comment');
    }
}