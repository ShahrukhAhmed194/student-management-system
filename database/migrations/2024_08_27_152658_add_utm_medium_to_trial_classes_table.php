<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUtmMediumToTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            $table->string('utm_medium')->after('sales_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            $table->dropColumn('utm_medium');
        });
    }
}
