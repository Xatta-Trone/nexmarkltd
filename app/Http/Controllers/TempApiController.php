<?php

namespace App\Http\Controllers;

use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProductResource;

class TempApiController extends Controller
{
    public function products()
    {
        $page = request()->get('page', 1);
        $paginate = request()->get('per_page', 30);
        $offSet = ($page * $paginate) - $paginate;

                
        if (request()->get('cat') != null) {
            $products = Product::whereHas('categories', function ($query) {
                $query->where('slug', 'like', request()->get('cat'));
            })->orderBy('id', 'desc');
        } elseif (request()->get('query') != null) {
            $products = Product::where('name', 'like', '%'.request()->get('query').'%')->orderBy('id', 'desc');
        } else {
            $products = Product::orderBy('id', 'desc');
        }
        // return ProductResource::collection($products->skip($offSet)->take($paginate)->get()) ;
        return ProductResource::collection($products->paginate($paginate)) ;
        


        
        // dd($products->toArray());
        // return view('user.shop', compact('categories', 'products'));
    }

    public function allCategories()
    {
        $categories = Category::with('children')->where('status', 1)->where('parent_category', null)->orderBy('name', 'asc')->get();

        return CategoriesResource::collection($categories);
    }
}
