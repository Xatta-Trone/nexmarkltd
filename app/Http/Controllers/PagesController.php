<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
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
}
