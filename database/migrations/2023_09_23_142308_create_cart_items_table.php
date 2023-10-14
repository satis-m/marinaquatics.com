<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->string('product_slug');
            $table->int('quantity');
            $table->string('offer_name');
            $table->int('offer_quantity');
            $table->float('offer_price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
