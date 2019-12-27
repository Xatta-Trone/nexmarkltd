<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Permission;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
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
        return view('admin.roles.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distinct_permissions = Permission::distinct()->get(['for_w'])->toArray();
        $permissions = Permission::all();
       
        return view('admin.roles.add', compact('distinct_permissions', 'permissions'));
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
            
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect(route('roles.index'))->with('success', 'role added');
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
        $distinct_permissions = Permission::distinct()->get(['for_w'])->toArray();
        $permissions = Permission::all();
        $role = Role::with('permissions')->where('id', $id)->get()->first();
        return view('admin.roles.edit', compact('distinct_permissions', 'permissions', 'role'));
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
            'name'=>'required',
            
        ]);

        $role =  Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect(route('roles.index'))->with('success', 'role updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->permissions()->sync([]);
        $role->delete();
        return redirect(route('roles.index'))->with('success', 'role deleted');
    }

    public function ajaxDataTable()
    {
        $roles = Role::query();

        return DataTables::of($roles)
        ->addColumn('action', function ($role) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('roles.edit', $role->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$role->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$role->id.'" action="'.route('roles.destroy', $role->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('created_at', function ($role) {
            return $role->created_at->diffForHumans();
        })
        ->rawColumns(['action'])
        
        
        ->make(true);
    }
}
