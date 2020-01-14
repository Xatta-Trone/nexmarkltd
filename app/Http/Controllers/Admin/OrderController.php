<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Shop;
use App\Model\Admin\Admin;
use App\Model\Admin\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use LaravelDaily\Invoices\Classes\Party;
use Yajra\DataTables\Facades\DataTables;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class OrderController extends Controller
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
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'under construction';
        $shops = Shop::where('status', 1)->get();
        $orders = Order::select(['id','name','price','slug'])->where('status', 1)->get();
        return view('admin.orders.add', compact('shops', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $order = Order::find($id);
        $order->items = explode('|', $order->items) ;
        return view('admin.orders.edit', compact('order'));
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
        $order = Order::find($id);
        $order->update($request->all());
        return redirect(route('orders.index'))->with('success', 'order updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id)->delete();
        return redirect(route('orders.index'))->with('success', 'order deleted');
    }

    public function ajaxDataTable()
    {
        $orders = Order::query();

        return DataTables::of($orders)
        ->addColumn('action', function ($order) {
            $col_to_show = '';
            
            $col_to_show .= '  <a href="'.route('orders.edit', $order->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
            $col_to_show .= '  <a href="'.route('orders.invoice', $order->id).'" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>';
            if ($order->status == 'pending_verification') {
                $col_to_show .= '  <a onclick="return confirm(\'are you sure ?\')" href="'.route('orders.updateorder', $order->id).'" class="btn btn-info"><i class="fa fa-check"></i></a>';
            }

            // $col_to_show .= '  <a href="'.route('orders.edit', $order->id).'" class="btn btn-primary"><i class="fa fa-search-plus"></i></a>';

            $col_to_show .= '<a href="#" class="btn btn-primary" id="order$orderViewModal" data-id=' . $order->id .'><i class="fa fa-eye"></i></a>';
            
            $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$order->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <form id="delete-form-'.$order->id.'" action="'.route('orders.destroy', $order->id).'" method="post">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                  </form>';
            
            return $col_to_show;
        })
        ->editColumn('trx_type', function ($order) {
            $status_col = '';
            if ($order->trx_type == 'bkash') {
                $status_col .=  '<span class="label label-primary">BKash</span>';
            } elseif ($order->trx_type == 'rocket') {
                $status_col .=  '<span class="label label-info">Rocket</span>';
            } else {
                $status_col .=  '<span class="label label-danger">Unknown</span>';
            }
            return $status_col;
        })
        ->editColumn('status', function ($order) {
            // <option value="0" selected>Drafted</option>
            // <option value="1">Published</option>
            // <option value="2">Hidden</option>
            // <option value="3">Custom</option>
            $status_col = '';
            // switch ($order->status) {
            //     case "pending":
            //         return `<span class="badge badge-pill badge-warning">
            //                 Pending
            //             </span>`;
            //         break;
            //     case "pending_payment":
            //         return `<span class="badge badge-pill badge-info">
            //                 Pending Payment
            //             </span>`;
            //         break;
            //     case "pending_verification":
            //         return `<span class="badge badge-pill badge-info">
            //                 Pending Payment verification
            //             </span>`;
            //         break;
            //     case "paid":
            //         return `<span class="badge badge-pill badge-success">
            //                 Paid
            //             </span>`;
            //         break;
            //     case "cancelled ":
            //         return `<span class="badge badge-pill badge-danger">
            //                 Cancelled
            //             </span>`;
            //         break;
            //     case "delivered ":
            //         return `<span class="badge badge-pill badge-success">
            //                 Delivered
            //             </span>`;
            //         break;
            //     default:
            //         return `<span class="badge badge-pill badge-dark">
            //                 Pending
            //             </span>`;
            //         break;
            // }
            if ($order->status == 'pending') {
                $status_col .=  '<span class="label label-pill label-warning">Pending</span>';
            } elseif ($order->status == 'pending_payment') {
                $status_col .=  '<span class="label label-pill label-info">Pending Payment</span>';
            } elseif ($order->status == 'pending_verification') {
                $status_col .=  '<span class="label label-pill label-info">Pending Payment verification</span>';
            } elseif ($order->status == 'paid') {
                $status_col .=  '<span class="label label-pill label-success">Paid</span>';
            } elseif ($order->status == 'cancelled') {
                $status_col .=  '<span class="label label-pill label-danger">Cancelled</span>';
            } elseif ($order->status == 'delivered') {
                $status_col .=  '<span class="label label-pill label-success">Delivered</span>';
            } else {
                $status_col .=  '<span class="label label-pill label-dark">Pending</span>';
            }

            return $status_col;
        })
        ->rawColumns(['action','status','trx_type'])
        
        
        ->make(true);
    }

    public function updateorder($id)
    {
        $order = Order::where('id', $id)->get()->first();
        // dd($order);
        $order->update(['status'=>'paid']);
        Artisan::call('order:paid', ['orderId'=> $id]);
        // return $order;
        return redirect(route('orders.index'))->with('success', 'payment updated');
    }

    public function generateInvoice($id)
    {
        $order = Order::where('id', $id)->get()->first();
        $settings  = DB::table('order_settings')->where('id', 1)->first();

        $order->items = explode('|', $order->items);
        // dd($order->items);
        $client = new Party([
            'name'          => $settings->company_name,
            'phone'         => $settings->phone,
            'address'       => $settings->address,
            'custom_fields' => [
                'email'         => $settings->email,
            ],
            
        ]);

        $customer = new Party([
            'name'          => $order->name,
            'phone'          => $order->phone,
            'address'       => $order->shipping_address,
        ]);

        $items = [];

        foreach ($order->items as $item) {
            $decoded_item = json_decode($item);
            $items[] = (new InvoiceItem())->title($decoded_item->name)->pricePerUnit($decoded_item->price)->quantity($decoded_item->qty);
        }
        // $items[] = (new InvoiceItem())->title('Shipping charge')->pricePerUnit(50)->quantity(1);

        $notes = [
            $order->note
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('INVOICE')
            ->series('NMS')
            ->sequence($order->id)
            ->serialNumberFormat('{SERIES}{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->template('custom')
            ->date($order->created_at)
            ->dateFormat('d-m-Y')
            ->totalAmount($order->total_amount)
            ->currencyFormat('{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename('order_#'.$order->id)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('storage/settings/'.$settings->logo));
        // You can additionally save generated invoice to configured disk
        // ->save('public');
            
        // $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }
}
