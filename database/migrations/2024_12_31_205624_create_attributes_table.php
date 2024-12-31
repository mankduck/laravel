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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_catalogue_id')->unsigned();
            $table->foreign('attribute_catalogue_id')->references('id')->on('attribute_catalogues')->onDelete('cascade');
            $table->string('image', 191)->nullable();
            $table->string('icon', 191)->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->tinyInteger('follow')->default(1);
            $table->integer('order')->default(0);
            $table->bigInteger('user_id')->unsigned();
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
        Schema::dropIfExists('attributes');
    }
};
