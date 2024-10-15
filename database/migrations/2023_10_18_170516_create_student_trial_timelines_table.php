<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTrialTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_trial_timelines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('trial_class_id');

            $table->integer('registration_complete')->nullable();
            $table->date('registration_complete_date')->nullable();
            $table->time('registration_complete_time')->nullable();

            $table->integer('will_attend')->nullable();
            $table->date('will_attend_date')->nullable();
            $table->time('will_attend_time')->nullable();

            $table->integer('rescheduled')->nullable();
            $table->date('rescheduled_date')->nullable();
            $table->time('rescheduled_time')->nullable();

            $table->integer('attended')->nullable();
            $table->date('attended_date')->nullable();
            $table->time('attended_time')->nullable();
            
            $table->integer('refused_admission')->nullable();
            $table->date('refused_admission_date')->nullable();
            $table->time('refused_admission_time')->nullable();

            $table->integer('payment_complete')->nullable();
            $table->date('payment_complete_date')->nullable();
            $table->time('payment_complete_time')->nullable();

            $table->integer('admission_complete')->nullable();
            $table->date('admission_complete_date')->nullable();
            $table->time('admission_complete_time')->nullable();
            $table->timestamps();

            
            $table->foreign('student_id')->references('id')->on('students'); // Foreign key constraint
            $table->foreign('trial_class_id')->references('id')->on('trial_classes'); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_trial_timelines');
    }
}
