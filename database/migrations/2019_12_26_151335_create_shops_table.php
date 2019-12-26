<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('name');
            $table->text('trade_license');
            $table->text('website_url');
            $table->text('email');
            $table->text('phone');
            $table->text('addr_1');
            $table->text('addr_2')->nullable();
            $table->integer('status')->default(0);
            $table->text('trade_license_file');
            $table->text('approved_by')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
