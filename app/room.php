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
}
