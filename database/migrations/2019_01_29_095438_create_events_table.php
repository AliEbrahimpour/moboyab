<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_target_id');
            $table->integer('action_id')->unsigned()->index();
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
//            $table->integer('command_id')->unsigned()->index();
//            $table->foreign('command_id')->references('id')->on('commands')->onDelete('cascade');
            $table->string('status_number')->default(0);
            $table->string('delivery_status')->default(0);
            $table->string('delivery_state_id')->default(0);
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('events');
    }
}
