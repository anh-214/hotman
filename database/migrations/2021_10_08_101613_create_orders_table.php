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
            $table->text('type');
            $table->string('payment_type');
            $table->integer('checkout_status');
            $table->text('details_address');
            $table->string('confirmed_at')->nullable();
            $table->string('start_deliver_at')->nullable();
            $table->string('delivered_at')->nullable();
            $table->string('deleted_at')->nullable();
            $table->string('problem')->nullable();
            $table->string('is_read');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ward_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ward_id')->references('id')->on('wards');
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
        Schema::dropIfExists('orders');
    }
}
