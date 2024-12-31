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
        Schema::create('post_catalogues', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default(0);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedInteger('rgt')->default(0); 
            $table->unsignedInteger('level')->default(0);
            $table->string('image', 191)->nullable();
            $table->string('icon', 191)->nullable(); 
            $table->text('album')->nullable(); 
            $table->tinyInteger('publish')->default(1);
            $table->unsignedInteger('order')->default(0); 
            $table->tinyInteger('follow')->default(0); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogues');
    }
};
