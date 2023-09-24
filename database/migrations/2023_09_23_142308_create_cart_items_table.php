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
            $table->string('cart_id');
            $table->string('product');
            $table->string('quantity');
            $table->string('offer_name');
            $table->string('offer_quantity');
            $table->string('offer_price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
