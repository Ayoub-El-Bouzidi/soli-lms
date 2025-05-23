<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = ['name','slug'];

    public function articles(){
        return $this->belongsToMany(Article::class,'article_tag');
    }
}
