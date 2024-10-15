<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegularClassIdToTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            $table->foreignId('da_class_id')->after('trial_class_id')->nullable()->constrained()->cascadeOnDelete();
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
            $table->dropColumn('da_class_id');
            $table->dropForeign(['da_class_id']);
        });
    }
}
