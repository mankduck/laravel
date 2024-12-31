<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attribute_catalogue_attribute', function (Blueprint $table) {
            $table->bigInteger('attribute_catalogue_id')->unsigned();
            $table->bigInteger('attribute_id')->unsigned();
            $table->foreign('attribute_catalogue_id')->references('id')->on('attribute_catalogues')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_catalogue_attribute');
    }
};
