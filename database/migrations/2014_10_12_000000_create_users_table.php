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
            $table->increments('id');
            $table->string('firstname')->default(0);
            $table->string('lastname')->default(0);
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role',['admin','user'])->default('user');
            $table->string('password');
            $table->string('code',4)->unique()->index();
            $table->double('star')->default(0);
//            $table->integer('device_id');
            $table->bigInteger('credit')->default(0);
            $table->string('avatar')->default(0);
            $table->string('active_number')->nullable();
//            $table->string('backup_number')->default(0);
//            $table->string('IBAN')->default(0);
//            $table->tinyInteger('pay')->default(0);
            $table->tinyInteger('buy_status')->default(0);
            $table->enum('account_status',['active','deactive','block'])->default('deactive');
            $table->dateTime('expire_plan')->nullable();
//            $table->boolean('user_status')->default(0);
            $table->string('api_token')->default(0);
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
