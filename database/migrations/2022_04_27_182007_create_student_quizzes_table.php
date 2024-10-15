<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->onUpdate('cascade')->onDelete('set null');
            $table->integer('student_id');
            $table->string('quiz_status');
            $table->integer('mark');
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
        Schema::dropIfExists('student_quizzes');
    }
}
