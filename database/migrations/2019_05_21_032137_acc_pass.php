<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccPass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('AccPass', function (Blueprint $table) {
            $table->string('userName')->unique();
            $table->string('passsword');
            $table->bigIncrements('cusId');
            $table->string('userPhone');
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('AccPass', function($table) {
            $table->foreign('cusId') 
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
        Schema::dropIfExists('AccPass');
    }
}
