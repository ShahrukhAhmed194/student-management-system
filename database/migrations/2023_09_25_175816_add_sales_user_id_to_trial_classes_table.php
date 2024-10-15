<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalesUserIdToTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            $table->integer('sales_user_id')->after('feed_back')->nullable();
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
            $table->dropColumn('sales_user_id');
        });
    }
}
