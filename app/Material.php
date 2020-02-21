<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    public function materialable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->belongsToMany('App\Item');
    }
}
