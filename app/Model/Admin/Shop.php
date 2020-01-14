<?php

namespace App\Model\Admin;

use App\Model\Admin\Order;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
