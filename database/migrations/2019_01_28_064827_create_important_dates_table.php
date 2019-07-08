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
            $table->integer('site_id')->unsigned();
            $table->integer('imp_date_menu_id')->unsigned();
            $table->date('imp_date');
            $table->index('site_id');
            $table->index('imp_date_menu_id');
            $table->foreign('site_id')->references('id')->on('target_org')->onDelete('cascade');
            $table->foreign('imp_date_menu_id')->references('id')->on('idatemenus')->onDelete('cascade');
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
