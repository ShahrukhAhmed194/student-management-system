<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('trial_class_id');
            $table->string('gurdian_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            $table->string('country')->nullable();
            $table->boolean('hasDevice')->default(true);
            $table->string('hear_from')->nullable();
            $table->string('school');
            $table->string('student_name');
            $table->integer('age');
            $table->string('gender');
            $table->string('status')->default('Registered');
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
        Schema::dropIfExists('trial_classes');
    }
}
