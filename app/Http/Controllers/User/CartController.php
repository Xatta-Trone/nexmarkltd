<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Order;
use App\Model\User\Cart;
use Illuminate\Support\Facades\Artisan;

class CartController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth')->only(['index','checkout']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.cart');
    }

    public function createOrder()
    {
        // return request()->all();
        $sum = 0;

        $cartItems = Cart::where('shop_id', request()->shop_id)->pluck('item')->toArray();
        foreach ($cartItems as $item) {
            $decodedItem = json_decode($item);
            $sum += $decodedItem->price*$decodedItem->qty;
        }

        $order = new Order;
        $order->shop_id = request()->shop_id;
        $order->user_id = auth()->user()->id;
        $order->name = request()->name;
        $order->phone = request()->phone;
        $order->shipping_address = request()->shipping_address;
        $order->total_amount = $sum;
        $order->trx_type = request()->trx_type;
        $order->status = 'pending_payment';
        $order->note = request()->note;
        $order->items = implode('|', $cartItems);
        $order->save();

        Artisan::call('cart:clear', ['shop_id'=>request()->shop_id]);

        return redirect(route('payment.show', ['type'=>$order->trx_type,'id'=>base64_encode($order->id)]));
    }


    public function payment($type, $id)
    {
        $order_id = (int) base64_decode($id);
        $order_details = Order::where('id', $order_id)->get()->first();

        if ($type == 'bkash') {
            return view('user.payment.bkash')->with('order_details', $order_details);
        } elseif ($type == 'rocket') {
            return view('user.payment.rocket')->with('order_details', $order_details);
        }
    }

    public function makePayment(Request $request)
    {
        // dd(request()->id);
        $update = Order::where('id', $request->id)->update(
            [
                'trx_id'=>$request->trx_id,
                'trx_type'=>$request->trx_type,
                'status'=>'pending_verification'
            ]
        );
        if ($update) {
            return view('user.thankyou')->with('order_details', Order::where('id', $request->id)->get()->first());
        }
    }






    public function setCartItem()
    {
        //search params
        $cartItemSearch['shop_id'] = auth()->user()->shop_id ? auth()->user()->shop_id : 0;
        $cartItemSearch['product_id'] = request()->id;

        //create params
        $cartItem['shop_id'] = auth()->user()->shop_id ? auth()->user()->shop_id : 0;
        $cartItem['product_id'] = request()->id;
        $cartItem['qty'] = request()->qty;
        $cartItem['item'] = json_encode(request()->all());

        return Cart::updateOrCreate($cartItemSearch, $cartItem);
    }

    public function updateCartItem()
    {
        // dd(request()->all());
        return Cart::where('product_id', request()->id)->where('shop_id', auth()->user()->shop_id)->update(['qty'=>request()->qty]);
    }

    public function getCartItemsByShop()
    {
        $items = Cart::where('shop_id', auth()->user()->shop_id)->get();
        return $items->map(function ($item) {
            return json_decode($item->item);
        });
    }

    public function deletItem()
    {
        // return request()->all();
        return Cart::where('product_id', request()->id)->where('shop_id', auth()->user()->shop_id)->delete();
    }

    public function checkout()
    {
        return view('user.checkout');
    }
}
