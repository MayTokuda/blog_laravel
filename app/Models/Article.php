<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    public function tags(){
        return $this -> hasMany('App\Models\Tag');
    }   


    // Articleモデル(親)
    // 
    // articlesテーブル(親)とcommentsテーブル(子)のリレーション
    
    public function comments(){
        return $this -> hasMany('App\Models\Comment');
    }
}