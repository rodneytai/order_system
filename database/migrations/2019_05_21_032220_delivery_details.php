<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeliveryDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('DeliveryDetails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('dId');
            $table->integer('dOrderId')->length(20)->unsigned(); 
            $table->string('dStatus', 10); 
            $table->string('dTime', 20)->nullable(); 
            $table->string('dArriveTime', 20)->nullable();
        });
        Schema::table('DeliveryDetails', function($table) {
            $table->foreign('dOrderId') 
                  ->references('orderId')->on('OrderInfo')
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
        Schema::dropIfExists('DeliveryDetails');
    }
}
