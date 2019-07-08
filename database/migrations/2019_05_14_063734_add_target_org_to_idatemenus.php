<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetOrgToIdatemenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idatemenus', function($table) {
            $table->integer('targetorg_id')->unsigned()->nullable()->after('id');
            $table->index('targetorg_id');
            $table->foreign('targetorg_id')->references('id')->on('target_org')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idatemenus', function($table) {
            $table->dropForeign('idatemenus_targetorg_id_foreign');
            $table->dropIndex('idatemenus_targetorg_id_index');
            $table->dropColumn('targetorg_id');
        });
    }
}
