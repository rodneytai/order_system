<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::create('CustomerInfo', function (Blueprint $table) {
        //     $table->bigIncrements('cusId', 10);
        //     $table->string('cusName', 20);
        //     $table->string('cusPhone', 15);
        //     $table->string('cusAddress', 50);
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('CustomerInfo');
    }
}
