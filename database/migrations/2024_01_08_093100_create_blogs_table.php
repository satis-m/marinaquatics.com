<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable()->index();
            $table->longText('body');
            $table->string('tag')->nullable()->index();
            $table->string('category')->index();
            $table->boolean('publish')->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::statement('CREATE FULLTEXT INDEX blogs_fulltext ON blogs(title, body, category) WITH PARSER ngram');
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
