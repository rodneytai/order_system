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
            $table->engine = 'InnoDB';
            $table->increments('orderId', 20)->unsigned();
            $table->string('orderGoods', 20)->unsigned(); //商品
            $table->string('orderUnit', 10); //單位
            $table->decimal('orderUnitPrice', 10, 2); //單位價
            $table->integer('orderAmount')->length(20)->unsigned(); //數量
            $table->decimal('orderTotal', 10, 2); //金額
            $table->integer('orderCus')->length(20)->unsigned();
        });
        Schema::table('OrderInfo', function($table) {
            $table->foreign('orderGoods') 
                  ->references('pId')->on('ProductInfo')
                  ->onUpdate('cascade');  //overwrite on update
            $table->foreign('orderCus') 
                  ->references('id')->on('users')
                  ->onUpdate('cascade');  //overwrite on update
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
