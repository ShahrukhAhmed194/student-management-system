<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAvailableSeatsOfTrialClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_class_schedules', function (Blueprint $table) {
            $table->string('available_seats')->default(15)->change();
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
            $table->string('available_seats')->default(10)->change();
        });
    }
}