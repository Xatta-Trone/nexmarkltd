<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Admin\Category;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    protected $category;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_categories = Category::whereNull('parent_category')->get();
        return view('admin.categories.add')->with('categories', $all_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $category = new Category;

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_category = $request->parent_category;
        $category->status = $request->status;

        $category->save();

        return redirect(route('categories.index'))->with('success', 'category added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::whereNull('parent_category')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
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
        $category =  Category::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_category = $request->parent_category;
        $category->status = $request->status;
        $category->save();

        return redirect(route('categories.index'))->with('success', 'category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id)->delete();

        return redirect(route('categories.index'))->with('success', 'category deleted');
    }

    public function ajaxDataTable()
    {
        $categories = Category::query();

        return DataTables::of($categories)
        ->addColumn('action', function ($category) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('categories.edit', $category->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$category->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$category->id.'" action="'.route('categories.destroy', $category->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('status', function ($category) {
            $status_col = '';
            if ($category->status == 1) {
                $status_col .=  '<span class="label label-success">Active</span>';
            } else {
                $status_col .=  '<span class="label label-danger">Inactive</span>';
            }

            return $status_col;
        })
        ->editColumn('created_at', function ($category) {
            return $category->created_at->diffForHumans();
        })
        ->rawColumns(['action','status'])
        
        
        ->make(true);
    }
}
