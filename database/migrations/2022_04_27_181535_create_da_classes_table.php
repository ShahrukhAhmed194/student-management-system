<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('teacher_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('course_tracks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('course_levels')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('da_classes');
    }
}
