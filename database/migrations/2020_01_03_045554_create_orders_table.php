<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->unsignedBigInteger('shop_id')->index('shop_id');
            $table->unsignedBigInteger('user_id');
            $table->text('name');
            $table->text('phone');
            $table->longText('shipping_address');
            $table->double('total_amount', 10, 3);
            $table->double('discount', 10, 3)->default(0);
            $table->double('tax', 10, 3)->default(0);
            $table->text('trx_id')->nullable();
            $table->text('trx_type')->nullable();
            $table->text('status');
            $table->text('note')->nullable();
            $table->date('delivery_date')->nullable();
            $table->longText('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
