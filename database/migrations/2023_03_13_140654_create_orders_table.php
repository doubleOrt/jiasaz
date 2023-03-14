<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_response_id');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_delivery', 'delivered']);
            $table->timestamp('date_order_placed')->useCurrent();
            $table->integer('quantity')->default(1);

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('shop_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('order_response_id')->references('id')->on('order_responses');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}