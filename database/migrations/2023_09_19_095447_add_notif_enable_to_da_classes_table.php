<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifEnableToDaClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->boolean('notif_enable')->after('status')->default(1);

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
            $table->dropColumn('notif_enable');
        });
    }
}
