<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusesToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->bigInteger('admitted_by')->after('admitted_on')->nullable();
            $table->bigInteger('terminated_by')->after('terminated_on')->nullable();
            $table->date('on_hold_since')->after('terminated_by')->nullable();
            $table->bigInteger('on_hold_by')->after('on_hold_since')->nullable();
            $table->date('graduated_on')->after('on_hold_by')->nullable();
            $table->bigInteger('graduated_by')->after('graduated_on')->nullable();
            $table->date('deleted_on')->after('graduated_by')->nullable();
            $table->bigInteger('deleted_by')->after('deleted_on')->nullable();
            $table->bigInteger('updated_by')->after('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('admitted_by');
            $table->dropColumn('terminated_by');
            $table->dropColumn('on_hold_since');
            $table->dropColumn('on_hold_by');
            $table->dropColumn('graduated_on');
            $table->dropColumn('graduated_by');
            $table->dropColumn('deleted_on');
            $table->dropColumn('deleted_by');
            $table->dropColumn('updated_by');
        });
    }
}
