<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcmsubtitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocmsubtitle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('ocmtitle_id')->unsigned();
            $table->string('ocmsubtitle');
            $table->index('ocmtitle_id');
            $table->index('targetorg_id');
            $table->foreign('ocmtitle_id')->references('id')->on('ocmtitle')->onDelete('cascade');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
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
        Schema::dropIfExists('ocmsubtitle');
    }
}
