<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedTinyInteger('status')->default(1); // enum
            $table->date('delivery_date');
            $table->unsignedBigInteger('quantity'); // MMBTU
            $table->unsignedBigInteger('quantity_matched'); // MMBTU
            $table->unsignedBigInteger('quantity_pending'); // MMBTU
            $table->unsignedBigInteger('price'); // satang/MMBTU
            $table->unsignedSmallInteger('fee'); // fee in percent
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('bid_requests');
    }
}
