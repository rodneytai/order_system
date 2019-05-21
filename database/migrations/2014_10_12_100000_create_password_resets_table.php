<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('cusId', 10);
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('password_resets', function($table) {
            $table->foreign('cusId')
                  ->references('cusId')->on('CustomerInfo')
                  ->onUpdate('cascade') //更新覆蓋
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
