<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submenu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->string('submenu');
            $table->string('submenu_link');
            $table->index('targetorg_id');
            $table->index('menu_id');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade');
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
        Schema::dropIfExists('submenu');
    }
}
