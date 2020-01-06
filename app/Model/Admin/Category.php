<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

//     protected function all()
//     {
//         return Category::all();
//
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_category');
    }
    
    //each category might have multiple children
    public function children()
    {
        return $this->hasMany(static::class, 'parent_category')->orderBy('name', 'asc');
    }
}
