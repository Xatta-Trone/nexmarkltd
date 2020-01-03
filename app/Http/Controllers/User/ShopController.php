<?php

namespace App\Http\Controllers\User;

use App\Model\Admin\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function storeShopInfo(Request $request)
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
        $store->status             = 0;
        $store->trade_license_file = $NewFileToStore;
        $store->save();

        return redirect(route('submitstatus'))->with('message', 'Submitted Successfully');
    }

    public function validatetradelicense(Request $request)
    {
        // return $request->all();

        if (Shop::where('trade_license', $request->trade_license)->where('status', 1)->exists()) {
            return 1;
        } else {
            return 0;
        }
    }
}
