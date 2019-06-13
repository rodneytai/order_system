<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id', 20)->unsigned();
            $table->string('cusName', 20);
            $table->string('cusPhone', 15);
            $table->string('cusAddress', 50);
            $table->string('email')->unique();
            $table->string('userName')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('auth')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
