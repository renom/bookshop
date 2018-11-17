<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'description', 'pages', 'price', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }

    public function shops()
    {
        return $this->belongsToMany('App\Shops')->withTimestamps();
    }
}
