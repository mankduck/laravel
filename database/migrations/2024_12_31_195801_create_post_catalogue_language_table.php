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
        Schema::create('post_catalogue_language', function (Blueprint $table) {
            $table->bigInteger('post_catalogue_id')->unsigned(); 
            $table->bigInteger('language_id')->unsigned(); 
            $table->foreign('post_catalogue_id')->references('id')->on('post_catalogues')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name', 191); 
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_keyword', 191)->nullable();
            $table->text('meta_description')->nullable(); 
            $table->string('canonical', 191); 
            $table->index('canonical');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogue_language');
    }
};
