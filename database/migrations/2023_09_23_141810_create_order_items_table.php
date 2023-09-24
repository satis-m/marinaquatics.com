<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('product');
            $table->float('quantity');
            $table->string('offer_name');
            $table->float('offer_quantity');
            $table->float('offer_price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
