<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guest extends Model
{
    public function del_reservations()
    {
        return $this->hasMany('App\del_reservation');
    }
}
