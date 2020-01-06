<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->category = $category;
    }
    public function import()
    {
        // dd(request()->all());
        Excel::import(new ProductsImport, request()->file('products'));
        return 'ok';
    }

    public function view()
    {
        return view('admin.products.excell');
    }
}
