<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User ID column
            $table->string('mobile', 30)->nullable();
            $table->integer('available');
            $table->timestamps();

            
            $table->foreign('user_id')->references('id')->on('users'); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_users');
    }
}
