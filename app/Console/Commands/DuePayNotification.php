<?php

namespace App\Console\Commands;

use App\Mail\PayDue;
use App\Model\Admin\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DuePayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:duepay {orderId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends an email and text to the user for payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orderId = $this->argument('orderId');
        $orderdetails = Order::with('shop')->where('id', $orderId)->get()->first();
        // dd($orderdetails);
        Mail::to($orderdetails->shop->email)->send(new PayDue($orderdetails));
    }
}
