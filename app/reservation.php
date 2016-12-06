<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    public function room()
    {
        return $this->belongsTo('App\room');
    }

    public function guest()
    {
        return $this->belongsTo('App\guest');
    }
    public function room_type()
    {
        return $this->belongsTo('App\room_type');
    }
}
