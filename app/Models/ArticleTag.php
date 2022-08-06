<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article_tag extends Model
{
    
    use HasFactory;
    protected $table = 'article_tag';

    protected $fillable = [
        'article_id',
        'tag_id'
    ];
}