<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    public function reservations()
    {
        return $this->hasMany('App\reservation');
    }

    public function del_reservations()
    {
        return $this->hasMany('App\del_reservation');
    }

    public function room_type()
    {
        return $this->belongsTo('App\room_type', 'type_id');
    }
}
