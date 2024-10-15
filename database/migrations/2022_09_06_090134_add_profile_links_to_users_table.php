<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileLinksToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_profile')->nullable()->after('profile_photo_path');
            $table->string('facebook_profile')->nullable()->after('twitter_profile');
            $table->string('instagram_profile')->nullable()->after('facebook_profile');
            $table->string('linkedln_profile')->nullable()->after('instagram_profile');
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
            $table->dropColumn('twitter_profile');
            $table->dropColumn('facebook_profile');
            $table->dropColumn('instagram_profile');
            $table->dropColumn('linkedln_profile');
        });
    }
}
