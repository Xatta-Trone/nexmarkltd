<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function addedBy()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
