<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('billing_name');
            $table->string('billing_contact');
            $table->string('billing_address')->nullable();
            $table->string('vat_pan')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_info')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
