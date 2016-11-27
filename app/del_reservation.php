<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class del_reservation extends Model
{
    public function room()
    {
        return $this->belongsTo('App\room');
    }

    public function guest()
    {
        return $this->belongsTo('App\guest');
    }
}
