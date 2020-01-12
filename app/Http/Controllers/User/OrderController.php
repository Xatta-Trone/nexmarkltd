<?php

namespace App\Http\Controllers\User;

use App\Model\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $page = request()->get('page', 1);
        $paginate = request()->get('per_page', 10);
        $offSet = ($page * $paginate) - $paginate;


        $orders = Order::where('shop_id', auth()->user()->shop_id)->orderBy('id', 'desc')->paginate($paginate);
        
        $orders->map(function ($order) {
            return $order->items = explode('|', $order->items);
        });

        return $orders;
    }
}
