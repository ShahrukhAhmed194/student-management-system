<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartClassSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('start_class_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_session_id');
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->text('start_url')->nullable();
            $table->string('join_url')->nullable();
            $table->longText('zoom_response')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('start_class_sessions');
    }
}
