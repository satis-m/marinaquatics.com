<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combo_offers', function (Blueprint $table) {
            $table->id();
            $table->string('product')->unique()->index();
            $table->string('name_1')->nullable();
            $table->string('name_2')->nullable();
            $table->string('name_3')->nullable();
            $table->integer('quantity_1')->nullable();
            $table->integer('quantity_2')->nullable();
            $table->integer('quantity_3')->nullable();
            $table->float('price_1')->nullable();
            $table->float('price_2')->nullable();
            $table->float('price_3')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_offers');
    }
};
