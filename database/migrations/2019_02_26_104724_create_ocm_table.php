<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('ocmsubtitle_id')->unsigned();
            $table->string('name');
            $table->string('designation');
            $table->string('profile_image_path');
            $table->string('college');
            $table->string('department');
            $table->string('place');
            $table->string('country');
            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->index('targetorg_id');
            $table->index('ocmsubtitle_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
            $table->foreign('ocmsubtitle_id')->references('id')->on('ocmsubtitle')->onDelete('cascade');
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
        Schema::dropIfExists('ocm');
    }
}
