<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Commentモデル(子)
    // 
    // articlesテーブル(親)とcommentsテーブル(子)のリレーション
    
    public function comment(){
        return $this -> belongsTo('App\Models\comment');
    } 
}
