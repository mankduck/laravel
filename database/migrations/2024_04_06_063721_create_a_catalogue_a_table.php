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
        Schema::create('a_catalogue_a', function (Blueprint $table) {
    $table->unsignedBigInteger('a_catalogue_id');
    $table->unsignedBigInteger('a_id');
    $table->foreign('a_catalogue_id')->references('id')->on('a_catalogues')->onDelete('cascade');
    $table->foreign('a_id')->references('id')->on('as')->onDelete('cascade');
});
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('a_catalogue_a');
    }
};