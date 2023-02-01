<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bid_request_id');
            $table->foreignId('ask_request_id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('quantity'); // MMBTU
            $table->unsignedBigInteger('price'); // satang/MMBTU
            $table->unsignedSmallInteger('bid_fee'); // fee in percent
            $table->unsignedSmallInteger('ask_fee'); // fee in percent
            $table->unsignedBigInteger('buyer_spend'); // Satang
            $table->unsignedBigInteger('seller_received'); // Satang
            $table->timestamps();

            $table->foreign('bid_request_id')
                ->references('id')->on('bid_requests')
                ->onDelete('cascade');

            $table->foreign('ask_request_id')
                ->references('id')->on('ask_requests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
