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
                Schema::create('tesst_language', function (Blueprint $table) {
            $table->unsignedBigInteger('tesst_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('tesst_id')->references('id')->on('tessts')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical')->nullable();
            $table->timestamps();
        });       
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tesst_language');
    }
};