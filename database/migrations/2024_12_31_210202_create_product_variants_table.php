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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('code', 191)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('sku', 191)->nullable();
            $table->double('price', 8, 2)->default(0.00);
            $table->string('barcode', 191)->nullable();
            $table->string('file_name', 191)->nullable();
            $table->string('file_url', 191)->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('publish')->default(1);
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
        Schema::dropIfExists('product_variants');
    }
};
