<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBkashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bkashes', function (Blueprint $table) {
            $table->id();
            $table->json('response')->nullable();
            $table->string('debitMSISDN')->nullable();
            $table->string('trxID')->nullable();
            $table->string('transactionStatus')->nullable();
            $table->string('transactionType')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('dateTime')->nullable();
            $table->string('transactionReference')->nullable();
            $table->string('merchantInvoiceNumber')->nullable();
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
        Schema::dropIfExists('bkashes');
    }
}
