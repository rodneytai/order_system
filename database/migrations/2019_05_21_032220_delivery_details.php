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
            $table->bigIncrements('dId', 10);
            $table->string('dOrderId'); 
            $table->string('dStatus', 10); 
            $table->string('dTime', 20); 
            $table->string('dArriveTime', 20);
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
