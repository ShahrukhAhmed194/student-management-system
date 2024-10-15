<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoordinatorIdToTrialClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_class_schedules', function (Blueprint $table) {
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
        Schema::table('trial_class_schedules', function (Blueprint $table) {
            $table->dropColumn('coordinator_id');
        });
    }
}
