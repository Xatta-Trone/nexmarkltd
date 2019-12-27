<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Admin\Permission;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
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
        return view('admin.permissions.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' =>'required',
            'for_w'=>'required',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->for_w = $request->for_w;
        $permission->save();
        return redirect(route('permissions.index'))->with('success', 'permission added');
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
        $permission = Permission::find($id);
        return view('admin.permissions.edit', compact('permission'));
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
        $this->validate($request, [
            'name' =>'required',
            'for_w'=>'required',
        ]);

        $permission =  Permission::find($id);
        $permission->name = $request->name;
        $permission->for_w = $request->for_w;
        $permission->save();
        return redirect(route('permissions.index'))->with('success', 'permission updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect(route('permissions.index'))->with('success', 'permission deleted');
    }

    public function ajaxDataTable()
    {
        $permissions = Permission::query();

        return DataTables::of($permissions)
        ->addColumn('action', function ($permission) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('permissions.edit', $permission->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$permission->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$permission->id.'" action="'.route('permissions.destroy', $permission->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('created_at', function ($permission) {
            return $permission->created_at->diffForHumans();
        })
        ->rawColumns(['action'])
        
        
        ->make(true);
    }
}
