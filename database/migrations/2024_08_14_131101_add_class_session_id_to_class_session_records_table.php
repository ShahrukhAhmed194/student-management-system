<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassSessionIdToClassSessionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_session_records', function (Blueprint $table) {
            $table->foreignId('class_session_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_session_records', function (Blueprint $table) {
            $table->dropForeign(['class_session_id']);
            $table->dropColumn('class_session_id');
        });
    }
}
