<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onUpdate('cascade')->onDelete('set null');
            $table->integer('student_id');
            $table->string('project_status');
            $table->string('project_assesment');
            $table->text('comments');
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
        Schema::dropIfExists('student_projects');
    }
}
