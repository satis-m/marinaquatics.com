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
            $table->string('title')->nullable();
            $table->tinyText('detail')->nullable();
            $table->string('link_text')->nullable();
            $table->string('link')->default('#');
            $table->tinyInteger('publish')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
