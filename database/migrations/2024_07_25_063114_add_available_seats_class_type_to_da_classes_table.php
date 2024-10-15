<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableSeatsClassTypeToDaClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->integer('available_seats')->after('status')->default(10);
            $table->string('type')->after('available_seats')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('da_classes', function (Blueprint $table) {
            $table->dropColumn('available_seats');
            $table->dropColumn('type');
        });
    }
}
