<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('journal_id')->unsigned();
            $table->integer('abstract_id');
            $table->string('volume');
            $table->string('issue');
            $table->index('journal_id');
            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('cascade');
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
        Schema::dropIfExists('journal_papers');
    }
}
