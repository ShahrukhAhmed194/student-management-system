<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_sessions', function (Blueprint $table) {
            $table->id();
            $table->time('session_started');
            $table->time('session_ended')->nullable();
            $table->date('session_date');
            $table->string('session_id')->unique();
            $table->string('class_id');
            $table->string('status');
            $table->string('comments')->nullable();
            $table->string('recording_link')->nullable();
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
        Schema::dropIfExists('class_sessions');
    }
}