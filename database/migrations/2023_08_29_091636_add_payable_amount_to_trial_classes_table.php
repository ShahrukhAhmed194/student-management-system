<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayableAmountToTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            $table->Integer('payable_amount')->after('gender')->default(0);
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
            $table->dropColumn('payable_amount');
        });
    }
}
