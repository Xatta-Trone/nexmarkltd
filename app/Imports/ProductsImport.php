<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Model\Admin\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name'  => $row['item_description'],
            'slug'  => Str::slug($row['item_description']) ,
            'quantity' => 0,
            'min_order_qty' => 1,
            'price' => $row['sales_price'],
            'avg_cost' => $row['avg_cost'],
            'image' => 'noa.png',
            'admin_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
