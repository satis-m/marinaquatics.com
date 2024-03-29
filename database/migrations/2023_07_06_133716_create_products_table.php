<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('product_info');
            $table->longText('description')->nullable();
            $table->string('slug')->unique()->nullable()->index();
            $table->string('tag')->nullable()->index();
            $table->string('sub_category');
            $table->string('type');
            $table->string('unit');
            $table->string('video_link')->nullable();
            $table->string('highlight')->nullable();
            $table->string('brand')->nullable()->index();
            $table->float('price');
            $table->integer('available_quantity')->default('0');
            $table->boolean('publish')->default('0');
            $table->boolean('featured')->default('0');
            $table->softDeletes();
            $table->timestamps();

        });
        DB::statement('CREATE FULLTEXT INDEX products_fulltext ON products(name,type, product_info, sub_category) WITH PARSER ngram');
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
