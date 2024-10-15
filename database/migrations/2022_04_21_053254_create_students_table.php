<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('class_id')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->string('school')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('admitted_on')->nullable();
            $table->timestamp('terminated_on')->nullable();
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
        Schema::dropIfExists('students');
    }
}
