<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableSeatsToTrialClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_class_schedules', function (Blueprint $table) {
            $table->integer('available_seats')->default(10)->after('status');
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
            $table->dropColumn('available_seats');
        });
    }
}
