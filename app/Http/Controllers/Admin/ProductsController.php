<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Admin;
use Illuminate\Support\Str;
use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use App\Imports\ProductsImport;
use App\Model\Admin\Permission;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
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
        return view('admin.products.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.products.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'price'=>'required',
            'min_order_qty'=>'required',
            'quantity'=>'required',
            // 'image'=>'required',
            // 'description'=>'required',
            'status'=>'required',
            
        ]);

        $productSlug  = $this->createSlug($request->name);
        // dd($productSlug);

        if ($request->hasFile('image')) {
            //retrive new file data
            // $extension          = $request->file('image')->getClientOriginalExtension();
            // $NewFileToStore     = $productSlug.'.'.$extension;
            // //save new data
            // $request->file('image')->storeAs('public/products/', $NewFileToStore);

            $originalImage      =  $request->file('image');
            $thumbnailImage     = Image::make($originalImage);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $productSlug.'.'.$extension;

            $thumbnailImage->save(public_path().'/storage/products/'.$NewFileToStore);
            $thumbnailImage->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnailImage->save(public_path().'/storage/thumbnail/'.$NewFileToStore);
        } else {
            $NewFileToStore     = 'noa.png';
        }

        $product = new Product;
        $product->name = $request->name;
        $product->slug = $productSlug;
        $product->quantity = $request->quantity;
        $product->min_order_qty = $request->min_order_qty;
        $product->price = $request->price;
        $product->unit = $request->unit ?? null;
        $product->market_price = $request->market_price ?? null;
        $product->description = $request->description;
        $product->admin_id = auth()->user()->id;
        $product->status = $request->status;
        $product->image = $NewFileToStore;
        $product->save();
        $product->categories()->sync($request->categories);


        return redirect(route('products.index'))->with('success', 'product added');
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
        $categories = Category::where('status', 1)->get();
        $product = Product::with('categories')->where('id', $id)->get()->first();
        return view('admin.products.edit', compact('categories', 'product'));
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
        // dd(storage_path())
        $this->validate($request, [
            'name'=>'required',
            'price'=>'required',
            'min_order_qty'=>'required',
            'quantity'=>'required',
            // 'image'=>'required',
            // 'description'=>'required',
            'status'=>'required',
            
        ]);

        $product = Product::find($id);
        $productSlug  = $this->createSlug($request->name, $id);


        if ($request->hasFile('image')) {
            //delete old image
            if (!empty($product->image) && $product->image != 'noa.png') {
                Storage::delete('public/products/'.$product->image);
            }
            //retrive new file data
            $originalImage      =  $request->file('image');
            $thumbnailImage        = Image::make($originalImage);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $productSlug.'.'.$extension;

            $thumbnailImage->save(public_path().'/storage/products/'.$NewFileToStore);
            $thumbnailImage->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnailImage->save(public_path().'/storage/thumbnail/'.$NewFileToStore);


        // $request->file('image')->storeAs('public/products/', $NewFileToStore);
        } else {
            $NewFileToStore     = $product->image;
        }

        
        $product->name = $request->name;
        $product->slug = $productSlug;
        $product->quantity = $request->quantity;
        $product->min_order_qty = $request->min_order_qty;
        $product->price = $request->price;
        $product->unit = $request->unit ?? null;
        $product->market_price = $request->market_price ?? null;
        $product->description = $request->description;
        // $product->admin_id = auth()->user()->id;
        $product->status = $request->status;
        $product->image = $NewFileToStore;
        $product->save();
        $product->categories()->sync($request->categories);


        return redirect(route('products.index'))->with('success', 'product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!empty($product->image) && $product->image != 'noa.png') {
            Storage::delete('public/products/'.$product->image);
        }
        $product->delete();
        
        return redirect(route('products.index'))->with('success', 'successfully deleted');
    }

    public function excellImportView()
    {
        return view('admin.products.excell');
    }

    public function addexcelData()
    {
        Excel::import(new ProductsImport, request()->file('products'));
        return redirect(route('products.index'))->with('success', 'successfully imported');
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
            return "<img src=".asset('storage/thumbnail/'.$product->image)." height='50' width='auto' />";
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

    public function checkproduct(Request $request)
    {
        // return $request->all();
        if (Product::where('name', $request->product_name)->exists()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Product::select('slug')->where('slug', 'like', $slug.'%')
        ->where('id', '<>', $id)
        ->get();
    }

    public function getSingleProduct(Request $request)
    {
        return Product::with('addedBy', 'categories')->where('id', $request->id)->get()->first()->toArray();
    }
}
