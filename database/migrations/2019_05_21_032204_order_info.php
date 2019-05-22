<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('OrderInfo', function (Blueprint $table) {
            $table->bigIncrements('orderId')->unsigned();
            $table->string('orderGoods', 20); //商品
            $table->string('orderUnit', 10); //單位
            $table->decimal('orderUnitPrice', 10, 2); //單位價
            $table->decimal('orderAmount', 10, 2); //數量
            $table->decimal('orderTotal', 10, 2); //金額
            $table->string('orderCus', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('OrderInfo');
    }
}
