<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsZoomAutomatedToDaClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->integer('isZoomAutomated')->after('notif_enable')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->dropColumn('isZoomAutomated');
        });
    }
}
