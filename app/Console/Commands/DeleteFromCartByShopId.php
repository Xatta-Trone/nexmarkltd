<?php

namespace App\Console\Commands;

use App\Model\User\Cart;
use Illuminate\Console\Command;

class DeleteFromCartByShopId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:clear {shop_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clears the cart after successfull order place';

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
        $shop_id = $this->argument('shop_id');
        echo $shop_id;
        $collection = Cart::where('shop_id', $shop_id)->get(['id']);
        Cart::destroy($collection->toArray());
        echo 'deleted';
    }
}
