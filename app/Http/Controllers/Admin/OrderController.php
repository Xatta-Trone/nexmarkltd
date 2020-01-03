<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Shop;
use App\Model\Admin\Admin;
use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::where('status', 1)->get();
        $products = Product::select(['id','name','price','slug'])->where('status', 1)->get();
        return view('admin.orders.add', compact('shops', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxDataTable()
    {
        $products = Product::query();

        return DataTables::of($products)
        ->addColumn('action', function ($product) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('products.edit', $product->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';

            // $col_to_show .= '  <a href="'.route('products.edit', $product->id).'" class="btn btn-primary"><i class="fa fa-search-plus"></i></a>';

            $col_to_show .= '<a href="#" class="btn btn-primary" id="productViewModal" data-id=' . $product->id .'><i class="fa fa-eye"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$product->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$product->id.'" action="'.route('products.destroy', $product->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('image', function ($product) {
            return "<img src=".asset('storage/products/'.$product->image)." height='50' width='auto' />";
        })
        ->editColumn('admin_id', function ($product) {
            return Admin::find($product->admin_id)->name;
        })
        ->editColumn('status', function ($product) {
            // <option value="0" selected>Drafted</option>
            // <option value="1">Published</option>
            // <option value="2">Hidden</option>
            // <option value="3">Custom</option>
            $status_col = '';
            if ($product->status == 0) {
                $status_col .=  '<span class="label label-info">Drafted</span>';
            } elseif ($product->status == 1) {
                $status_col .=  '<span class="label label-success">Published</span>';
            } elseif ($product->status == 2) {
                $status_col .=  '<span class="label label-warning">Hidden</span>';
            } elseif ($product->status == 3) {
                $status_col .=  '<span class="label label-default">Custom</span>';
            } else {
                $status_col .=  '<span class="label label-danger">Undefined</span>';
            }

            return $status_col;
        })
        ->rawColumns(['action','status','image'])
        
        
        ->make(true);
    }
}
