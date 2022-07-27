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
    
    public function tag(){
        return $this -> belongsTo('App\Models\Tag');
    }  
}
