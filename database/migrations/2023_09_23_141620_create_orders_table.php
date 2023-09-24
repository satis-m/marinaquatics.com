<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->float('total_amount');
            $table->float('discount');
            $table->float('subtotal_amount');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('payment_info')->nullable();
            $table->string('order_status')->nullable();
            $table->string('order_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
