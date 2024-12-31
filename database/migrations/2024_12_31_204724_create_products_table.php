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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_catalogue_id')->default(0);
            $table->string('image', 191)->nullable();
            $table->string('icon', 191)->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->tinyInteger('follow')->default(1);
            $table->integer('order')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('code', 191)->default(0);
            $table->string('made_in', 191)->nullable();
            $table->double('price', 8, 2)->default(0.00);
            $table->text('attributeCatalogue')->nullable();
            $table->text('attribute')->nullable();
            $table->text('variant')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
