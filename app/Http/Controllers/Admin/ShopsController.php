<?php

namespace App\Http\Controllers\Admin;

use App\Model\User\User;
use App\Model\Admin\Shop;
use App\Mail\NewShopAdded;
use App\Model\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ShopsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->shop = $shop;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.shops.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shops.add');
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
            'name'                =>'required',
            'trade_license'       =>'required',
            'website_url'         =>'required',
            'email'               =>'required',
            'addr_1'              =>'required',
            'trade_license_file'  =>'required| mimes:pdf,jpg,jpeg,png | max:5632'
        ]);

        // dd($request->hasFile('trade_license_file'));

        if ($request->hasFile('trade_license_file')) {
            //retrive new file data
            $extension          = $request->file('trade_license_file')->getClientOriginalExtension();
            $NewFileToStore     = $request->trade_license.'.'.$extension;
            //save new data
            $request->file('trade_license_file')->storeAs('public/trdlc/', $NewFileToStore);
        } else {
            $NewFileToStore     = '';
        }

        $store = new Shop;
        $store->name               = $request->name;
        $store->trade_license      = $request->trade_license;
        $store->website_url        = $request->website_url;
        $store->email              = $request->email;
        $store->phone              = $request->phone;
        $store->addr_1             = $request->addr_1;
        $store->addr_2             = $request->addr_2;
        $store->status             = $request->status;
        $store->trade_license_file = $NewFileToStore;
        $store->approved_by        = auth()->user()->id;
        $store->save();

        return redirect(route('shops.index'))->with('success', 'successfully added');
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
        $shop = Shop::find($id);

        return view('admin.shops.edit', compact('shop'));
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
        // return $request->all();
        $this->validate($request, [
            'name'                =>'required',
            'trade_license'       =>'required',
            'website_url'         =>'required',
            'email'               =>'required',
            'addr_1'              =>'required',
        ]);

        // dd($request->hasFile('trade_license_file'));
        $store =  Shop::find($id);


        if ($request->hasFile('trade_license_file')) {
            //delete old image
            if (!empty($store->trade_license_file)) {
                Storage::delete('public/trdlc/'.$store->trade_license_file);
            }
            //retrive new file data
            $extension          = $request->file('trade_license_file')->getClientOriginalExtension();
            $NewFileToStore     = $request->trade_license.'.'.$extension;
            //save new data
            $request->file('trade_license_file')->storeAs('public/trdlc/', $NewFileToStore);
        } else {
            $NewFileToStore     = $store->trade_license_file;
        }

        
        $store->name               = $request->name;
        $store->trade_license      = $request->trade_license;
        $store->website_url        = $request->website_url;
        $store->email              = $request->email;
        $store->phone              = $request->phone;
        $store->addr_1             = $request->addr_1;
        $store->addr_2             = $request->addr_2;
        $store->status             = $request->status;
        $store->trade_license_file = $NewFileToStore;
        $store->save();

        return redirect(route('shops.index'))->with('success', 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Shop::find($id);

        if (!empty($store->trade_license_file)) {
            Storage::delete('public/trdlc/'.$store->trade_license_file);
            $store->delete();
        }
        return redirect(route('shops.index'))->with('success', 'successfully deleted');
    }

    public function ajaxDataTable()
    {
        $shops = Shop::query();

        return DataTables::of($shops)
        ->addColumn('action', function ($shop) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('shops.edit', $shop->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$shop->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$shop->id.'" action="'.route('shops.destroy', $shop->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            if ($shop->status == 0) {
                $col_to_show .= '  <a onclick="return confirm(\'Are you sure?\')"  href="'.route('shops.approve', $shop->id).'" class="btn btn-primary"><i class="fa fa-check-square-o"></i></a>';
            }


            $col_to_show .= '  <a  href="'.route('shops.previewfile', $shop->id).'" class="btn btn-primary"><i class="fa fa-eye"></i></a>';
            
            return $col_to_show;
        })
        ->editColumn('status', function ($shop) {
            $status_col = '';
            if ($shop->status == 1) {
                $status_col .=  '<span class="label label-success">Active</span>';
            } else {
                $status_col .=  '<span class="label label-danger">Inactive</span>';
            }

            return $status_col;
        })
        ->editColumn('addr_1', function ($shop) {
            return $shop->addr_1.$shop->addr_2;
        })
        ->editColumn('website_url', function ($shop) {
            return "<a href=".$shop->website_url.">".$shop->website_url."</a>";
        })
        ->editColumn('approved_by', function ($shop) {
            return ($shop->approved_by != null) ? Admin::find($shop->approved_by)->name : 'not approved';
        })
        ->editColumn('created_at', function ($shop) {
            return $shop->created_at->diffForHumans();
        })
        ->rawColumns(['action','status','website_url'])
        
        
        ->make(true);
    }

    public function previewFile($id)
    {
        $file = Shop::find($id)->trade_license_file;
        $fileurl = asset('/storage/trdlc/'.$file);

        dd($fileurl);
        return response()->file($fileurl);
    }

    public function approve($shopId)
    {
        $shop = Shop::find($shopId);

        $shop->status = 1;
        $shop->approved_by = auth()->user()->id;
        $shop->save();

        $this->registerUser($shop);
        return redirect(route('shops.index'))->with('success', 'shop approved');
    }
    public function registerUser($shop)
    {
        // dd($shop);
        $pass = Str::random(8);

        $user = new User;
        $user->name = $shop->name;
        $user->email = $shop->email;
        $user->password = bcrypt($pass);
        // $user->status = 1;
        $user->save();

        $newShopUser = $shop;
        $newShopUser['password'] = $pass;
        $newShopUser = (object) $newShopUser;

        // dd($newShopUser);

        Mail::to($shop->email)->send(new NewShopAdded($newShopUser));
    }
}
