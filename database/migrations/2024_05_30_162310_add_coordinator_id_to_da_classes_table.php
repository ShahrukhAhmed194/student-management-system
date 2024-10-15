<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoordinatorIdToDaClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->integer('coordinator_id')->after('teacher_id')->nullable();
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
            $table->dropColumn('coordinator_id');
        });
    }
}
