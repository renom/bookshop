<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'address'];

    public function books()
    {
        return $this->belongsToMany('App\Book')->withTimestamps();
    }
}
