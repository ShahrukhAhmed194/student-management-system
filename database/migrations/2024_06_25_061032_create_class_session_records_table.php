<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSessionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_session_records', function (Blueprint $table) {
            $table->id();
            $table->string('recording_id')->nullable();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->string('recording_start')->nullable();
            $table->string('recording_end')->nullable();
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->text('play_url')->nullable();
            $table->text('download_url')->nullable();
            $table->string('recording_type')->nullable();
            $table->string('video_id')->nullable();
            $table->text('vimeo_embed_html')->nullable();
            $table->timestamp('recording_downloaded')->nullable();
            $table->timestamp('recording_uploaded')->nullable();
            $table->timestamp('recording_deleted')->nullable();
            $table->string('recording_link')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('class_session_records');
    }
}
