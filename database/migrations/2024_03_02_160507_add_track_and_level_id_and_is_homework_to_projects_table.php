<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackAndLevelIdAndIsHomeworkToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('course_id')->after('link_student_after')->nullable();
            $table->integer('is_homework')->after('level_id')->defult(0);
            $table->longText('notes')->after('is_homework')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('is_homework');
            $table->dropColumn('notes');
        });
    }
}
