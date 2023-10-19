<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('product_slug');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('product_slug')->references('slug')->on('products')->onDelete('cascade');
            $table->unique(['customer_id', 'product_slug']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('wishlists');
    }
};
