<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTrialClassNotifyToTrialClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_class_schedules', function (Blueprint $table) {
            $table->integer('is_trial_class_notified')->after('available_seats')->default(0);
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
            $table->dropColumn('is_trial_class_notified');
        });
    }
}
