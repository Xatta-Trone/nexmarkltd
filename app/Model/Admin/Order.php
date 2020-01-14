<?php

namespace App\Model\Admin;

use App\Model\Admin\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [
       
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
