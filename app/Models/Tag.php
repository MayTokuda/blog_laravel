<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Tagモデル(子)
    // 
    // articlesテーブル(親)とtagsテーブル(子)のリレーション
    // 多対多のリレーション
    
    public function articles(){
        return $this -> belongsToMany(Article::class , 'article_tag' , 'tag_id' , 'article_id');
    }  
}
