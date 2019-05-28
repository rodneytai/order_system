<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ProductInfo', function (Blueprint $table) {
            $table->string('pId', 10)->unique();
            $table->string('pName', 20);
            $table->string('pUnit', 10);
            $table->decimal('pPrice', 8, 2);
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
        Schema::dropIfExists('ProductInfo');
    }
}
