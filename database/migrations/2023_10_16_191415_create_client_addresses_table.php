<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_contact')->nullable();
            $table->string('billing_landmark')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_contact')->nullable();
            $table->string('shipping_landmark')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unique(['customer_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('client_addresses');
    }
};
