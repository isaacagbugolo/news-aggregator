<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['key','name','base_url','meta'];
    protected $casts = ['meta' => 'array'];

    public function articles(){ return $this->hasMany(Article::class); }
}

