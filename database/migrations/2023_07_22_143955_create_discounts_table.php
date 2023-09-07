<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('product')->index();
            $table->integer('discount');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('remark');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
