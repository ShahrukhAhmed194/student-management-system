<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleDetialsDurationToCourseTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_tracks', function (Blueprint $table) {
            $table->string('title')->after('track_num')->nullable();
            $table->text('details')->after('title')->nullable();
            $table->integer('duration')->after('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_tracks', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('details');
            $table->dropColumn('duration');
        });
    }
}
