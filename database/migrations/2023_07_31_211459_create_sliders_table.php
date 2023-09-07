<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->tinyText('detail');
            $table->string('link');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
