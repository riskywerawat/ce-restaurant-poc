<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id');
            $table->foreignId('order_request_id');

            $table->foreign('menu_id')
            ->references('id')->on('menus')
            ->onDelete('cascade');

            $table->foreign('order_request_id')
            ->references('id')->on('order_requests')
            ->onDelete('cascade');

            $table->integer('quantity')->index();

            $table->unsignedTinyInteger('status')->default(1); // enum

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
        Schema::dropIfExists('order_items');
    }
}
