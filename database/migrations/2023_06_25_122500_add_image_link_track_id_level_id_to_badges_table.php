<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageLinkTrackIdLevelIdToBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->string('image_link')->after('title')->nullable();
            $table->integer('track_id')->after('image_link');
            $table->integer('level_id')->after('track_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->string('image_link')->after('title')->nullable();
            $table->integer('track_id')->after('image_link');
            $table->integer('level_id')->after('track_id');
        });
    }
}
