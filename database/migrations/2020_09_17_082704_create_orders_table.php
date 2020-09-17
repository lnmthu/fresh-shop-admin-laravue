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
            $table->string('code');
            $table->foreignId('user_id')->constrained();
            $table->decimal('total_price', 18, 2);
            $table->decimal('sub_total', 18, 2);
            $table->decimal('shipping_fee', 18, 2);
            $table->string('shipping_address');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->char('status', 1)->default('0');
            $table->timestamps();
            $table->softDeletes();
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
