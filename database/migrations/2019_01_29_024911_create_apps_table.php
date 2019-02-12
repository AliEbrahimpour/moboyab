<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('version_code')->default('0');
            $table->string('version_name')->default('0');
            $table->string('download_link')->default('0');
            $table->double('cost')->default('0');
            $table->double('off')->default('0');
            $table->timestamp('deleted_at')->nullable();
            $table->integer('downloaded_count')->default('0');

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
        Schema::dropIfExists('apps');
    }
}
