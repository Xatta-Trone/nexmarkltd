<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AdminDetails;
use App\Model\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Role;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admins.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.add', compact('roles'));
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
        $adminPass = Str::random(8);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($adminPass);
        $admin->status = $request->status;
        $admin->save();
        $admin->roles()->sync($request->role);


        $adminDataForMail = $request->all();
        $adminDataForMail['password'] = $adminPass;
        $adminDataForMail = (object) $adminDataForMail;

        // dd($adminDataForMail);

        Mail::to($request->email)->send(new AdminDetails($adminDataForMail));
        return redirect(route('admins.index'))->with('success', 'admin added');
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
        $admin = Admin::find($id);
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
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
        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->status = $request->status;
        $admin->save();
        $admin->roles()->sync($request->role);

        return redirect(route('admins.index'))->with('success', 'admin updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect(route('admins.index'))->with('success', 'admin deleted');
    }

    public function checkEmail(Request $request)
    {
        if (Admin::where('email', $request->email)->exists()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function ajaxDataTable()
    {
        $admins = Admin::query();

        return DataTables::of($admins)
        ->addColumn('action', function ($admin) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('admins.edit', $admin->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$admin->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$admin->id.'" action="'.route('admins.destroy', $admin->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('status', function ($admin) {
            $status_col = '';
            if ($admin->status == 1) {
                $status_col .=  '<span class="label label-success">Active</span>';
            } else {
                $status_col .=  '<span class="label label-danger">Inactive</span>';
            }

            return $status_col;
        })
        ->editColumn('created_at', function ($admin) {
            return $admin->created_at->diffForHumans();
        })
        ->rawColumns(['action','status'])
        
        
        ->make(true);
    }
}
