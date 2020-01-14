<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayDue extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $orderdata;
    public function __construct($orderdata)
    {
        $this->orderdata = $orderdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.duepay')
        ->subject('Incomplete Payment '. "NMS".sprintf('%05d', $this->orderdata->id))
        ->from('paymentnotify@example.com')->with([
            'orderName' => $this->orderdata->name,
            'orderPrice' => $this->orderdata->total_amount,
            'orderId' => "NMS".sprintf('%05d', $this->orderdata->id),
        ]);
    }
}
