<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tesst_catalogue_tesst', function (Blueprint $table) {
    $table->unsignedBigInteger('tesst_catalogue_id');
    $table->unsignedBigInteger('tesst_id');
    $table->foreign('tesst_catalogue_id')->references('id')->on('tesst_catalogues')->onDelete('cascade');
    $table->foreign('tesst_id')->references('id')->on('tessts')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tesst_catalogue_tesst');
    }
};