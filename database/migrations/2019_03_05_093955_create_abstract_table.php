<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbstractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abstract', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_with_id');
            $table->string('title');
            $table->string('keywords');
            $table->string('abstract');
            $table->string('author_name');
            $table->string('co_author_name');
            $table->string('topic');
            $table->string('subtopic');
            $table->string('inst_name');
            $table->string('attachment');
            $table->string('doi_no');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('dept');
            $table->string('comments');
            $table->integer('user_id');
            $table->integer('journal_id');
            $table->integer('proceeding_id');
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
        Schema::dropIfExists('abstract');
    }
}
