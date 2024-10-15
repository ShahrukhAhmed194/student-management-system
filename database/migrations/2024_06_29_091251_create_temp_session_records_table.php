<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempSessionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_session_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_session_id');
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('class_session_id')->references('id')->on('class_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_session_records');
    }
}
