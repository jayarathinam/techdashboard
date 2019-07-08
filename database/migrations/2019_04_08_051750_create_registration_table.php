<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('regcat_id')->unsigned();
            $table->integer('regtype_id')->unsigned();
            $table->bigInteger('amount');
            $table->index('targetorg_id');
            $table->index('regcat_id');
            $table->index('regtype_id');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
            $table->foreign('regcat_id')->references('id')->on('registration_category')->onDelete('cascade');
            $table->foreign('regtype_id')->references('id')->on('registration_type')->onDelete('cascade');
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
        Schema::dropIfExists('registration');
    }
}
