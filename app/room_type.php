<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room_type extends Model
{
    public function rooms()
    {
        return $this->hasMany('App\room');
    }

}