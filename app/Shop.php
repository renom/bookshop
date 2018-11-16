<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function books()
    {
        return $this->belongsToMany('App\Books')->withTimestamps();
    }
}
