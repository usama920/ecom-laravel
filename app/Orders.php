<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function orders() {
        return $this->hasMany('App\OrdersProducts','order_id');
    }
}
