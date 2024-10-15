<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zoom_topic')->nullable()->after('email');
            $table->string('zoom_meeting_id')->nullable()->after('zoom_topic');
            $table->string('zoom_password')->nullable()->after('zoom_meeting_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('zoom_topic');
            $table->dropColumn('zoom_meeting_id');
            $table->dropColumn('zoom_password');
        });
    }
}
