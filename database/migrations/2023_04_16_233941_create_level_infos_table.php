<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('track_id');
            $table->string('title');
            $table->text('details')->nullable();
            $table->text('final_outcome')->nullable();
            $table->string('duration')->nullable();
            $table->text('learning_outcomes')->nullable();
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
        Schema::dropIfExists('level_infos');
    }
}
