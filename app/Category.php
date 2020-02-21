<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function items()
    {
        return $this->belongsToMany('App\Item');
    }

    public function material()
    {
        return $this->morphOne('App\Material', 'materialable');
    }
}
