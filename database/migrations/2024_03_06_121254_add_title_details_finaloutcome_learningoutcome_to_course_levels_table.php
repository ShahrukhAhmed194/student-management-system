<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleDetailsFinaloutcomeLearningoutcomeToCourseLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_levels', function (Blueprint $table) {
            $table->string('title')->after('level_num')->nullable();
            $table->text('details')->after('title')->nullable();
            $table->string('final_outcome')->after('details')->nullable();
            $table->integer('duration')->after('final_outcome')->nullable();
            $table->text('learning_outcomes')->after('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_levels', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('details');
            $table->dropColumn('final_outcome');
            $table->dropColumn('duration');
            $table->dropColumn('learning_outcomes');
        });
    }
}
