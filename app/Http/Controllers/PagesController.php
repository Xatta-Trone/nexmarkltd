<?php

namespace App\Http\Controllers;

use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class PagesController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth')->only(['shoppage']);
    }

    public function home()
    {
        return view('user.home');
    }

    public function register()
    {
        return view('user.register');
    }

    public function submitstatus()
    {
        return view('user.submitStatus');
    }

    public function shoppage()
    {
        // $category = Input::get('cat');
        // dd(request()->get('cat'));

        // $categories = Category::with('children')->where('status', 1)->where('parent_category', null)->orderBy('name', 'asc')->get()->toJSON();
        // $products = Product::with('categories')->orderBy('id', 'desc')->whereHas()->limit(21)->get();

        // if (request()->get('cat') != null) {
        //     $products = Product::whereHas('categories', function ($query) {
        //         $query->where('slug', 'like', request()->get('cat'));
        //     })->orderBy('id', 'desc')->limit(21)->get();
        // } elseif (request()->get('query') != null) {
        //     $products = Product::where('name', 'like', '%'.request()->get('query').'%')->orderBy('id', 'desc')->limit(21)->get();
        // } else {
        //     $products = Product::orderBy('id', 'desc')->limit(21)->get();
        // }


        
        // dd($products->toArray());
        return view('user.shop');
    }

    
    public function customPasswordChange(Request $request)
    {
        // return $request->all();
        $message = [];
        $old_password = $request->old_password;
 
 
        if (!(Hash::check($old_password, Auth::user()->password))) {
            $message['message'] = 'old password do not match';
            $message['success'] = 'false';
            return $message;
        }
 
        if (strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            $message['message'] = 'new password can not be same as old password';
            $message['success'] = 'false';
            return $message;
        }
 
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        $message['message'] = 'password changed successfully.';
        $message['success'] = 'true';
 
        return $message;
    }
}
