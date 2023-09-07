<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('application_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('map_location')->nullable();
            $table->string('esewa_merchant')->nullable();
            $table->string('cod_threshold_amount')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_infos');
    }
};
