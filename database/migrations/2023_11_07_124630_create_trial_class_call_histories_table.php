<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialClassCallHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_class_call_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trial_class_id');
            $table->unsignedBigInteger('user_id');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('trial_class_id')->references('id')->on('trial_classes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trial_class_call_histories');
    }
}
