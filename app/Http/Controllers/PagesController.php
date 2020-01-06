<?php

namespace App\Http\Controllers;

use App\Model\Admin\Category;
use App\Model\Admin\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth')->only(['shoppage']);
    }

    public function home()
    {
        return view('user.home');
    }

    public function register()
    {
        return view('user.register');
    }

    public function submitstatus()
    {
        return view('user.submitStatus');
    }

    public function shoppage()
    {
        $categories = Category::with('children')->where('status', 1)->where('parent_category', null)->orderBy('name', 'asc')->get();
        $products = Product::orderBy('id', 'desc')->limit(21)->get();
        // dd($products);
        return view('user.shop', compact('categories', 'products'));
    }
}
