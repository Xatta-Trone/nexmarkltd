<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index('name');
            $table->text('slug')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('min_order_qty')->default(0);
            $table->double('price', 10, 3);
            $table->text('unit')->nullable();
            $table->double('market_price', 10, 3)->nullable();
            $table->bigInteger('total_sale')->default(0);
            $table->text('image');
            $table->longText('description')->nullable();
            $table->integer('admin_id')->unsigned();
            $table->integer('status')->default(0);
            $table->timestamps();
            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
