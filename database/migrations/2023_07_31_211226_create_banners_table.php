<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyText('detail')->nullable();
            $table->string('link');
            $table->string('type');
            $table->string('image');
            $table->string('video')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
