<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('order_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained('users');
            $table->boolean('approved_or_rejected')->default(true);
            $table->text('reason_for_rejection')->nullable();
            $table->timestamp('date_of_response')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_responses');
    }
}