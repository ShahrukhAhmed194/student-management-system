<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTrackLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_track_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('track_id');
            $table->unsignedBigInteger('level_id');
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('course_tracks')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('course_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_track_levels');
    }
}
