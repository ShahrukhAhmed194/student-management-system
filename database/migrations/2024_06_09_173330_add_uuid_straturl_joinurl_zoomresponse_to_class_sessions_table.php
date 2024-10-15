<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidStraturlJoinurlZoomresponseToClassSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->string('uuid')->after('comments')->nullable();
            $table->unsignedBigInteger('meeting_id')->after('uuid')->nullable();
            $table->text('start_url')->after('uuid')->nullable();
            $table->string('join_url')->after('start_url')->nullable();
            $table->longText('zoom_response')->after('join_url')->nullable();
            $table->integer('class_status')->after('zoom_response')->comment('1=host');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('meeting_id');
            $table->dropColumn('start_url');
            $table->dropColumn('join_url');
            $table->dropColumn('zoom_response');
            $table->dropColumn('class_status');
        });
    }
}
