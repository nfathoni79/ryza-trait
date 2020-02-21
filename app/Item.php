<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function material()
    {
        return $this->morphOne('App\Material', 'materialable');
    }

    public function materials()
    {
        return $this->belongsToMany('App\Material');
    }
}
