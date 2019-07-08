<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportantDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('important_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('idatemenus_id')->unsigned();
            $table->date('impdate');
            $table->index('targetorg_id');
            $table->index('idatemenus_id');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
            $table->foreign('idatemenus_id')->references('id')->on('idatemenus')->onDelete('cascade');
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
        Schema::dropIfExists('important_dates');
    }
}
