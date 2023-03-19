
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreign('shop_id')->references('id')->on('users');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('delivery_person_id');
            $table->timestamp('date_offer_made')->useCurrent();
            $table->timestamp('date_offer_replied_to')->nullable();
            $table->boolean('offer_reply')->nullable();
            $table->timestamp('date_delivered')->nullable();
            $table->string('item_condition_after_delivery')->nullable();
            $table->decimal('delivery_fee', 8, 2);

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('delivery_person_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}