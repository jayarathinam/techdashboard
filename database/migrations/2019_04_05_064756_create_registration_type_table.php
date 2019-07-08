<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targetorg_id')->unsigned();
            $table->integer('regmenu_id')->unsigned();
            $table->string('reg_type');
            $table->date('reg_type_date');
            $table->index('regmenu_id');
            $table->index('targetorg_id');
            $table->foreign('regmenu_id')->references('id')->on('registration_menu')->onDelete('cascade');
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
        Schema::dropIfExists('registration_type');
    }
}
