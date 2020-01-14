<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OrderSettingController extends Controller
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
    public function view()
    {
        $settings  = DB::table('order_settings')->where('id', 1)->first();
        return view('admin.orders.setting', compact('settings')) ;
    }

    public function update(Request $request)
    {
        // return $request->all();
        $settings  = DB::table('order_settings')->where('id', 1)->first();

        if ($request->hasFile('logo')) {
            //delete old image
           
            //retrive new file data
            $originalImage      =  $request->file('logo');
            $thumbnailImage     = Image::make($originalImage);
            $extension          = $request->file('logo')->getClientOriginalExtension();
            $NewFileToStore     = 'logo.'.$extension;

            $thumbnailImage->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            // $request->file('logo')->storeAs('public/settings/', $NewFileToStore);

            $thumbnailImage->save(public_path().'/storage/settings/'.$NewFileToStore);
            $request->logo = $NewFileToStore;
        }

        DB::table('order_settings')->where('id', 1)->update($request->except(['logo','_token','_method']));
        return redirect(route('order.setting'))->with('success', 'settings updated');
    }
}
