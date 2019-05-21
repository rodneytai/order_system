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
            $table->string('acc')->unique();
            $table->string('passsword');
            $table->foreign('cusId')
                  ->references('cusId')->on('CustomerInfo')
                  ->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('AccPass', function($table) {
            $table->foreign('cusId')
                  ->references('cusId')->on('CustomerInfo')
                  ->onUpdate('cascade'); //更新覆蓋
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
