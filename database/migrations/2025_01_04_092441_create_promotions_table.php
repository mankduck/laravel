<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->string('method');
            $table->json('discountInformation')->nullable();
            $table->integer('discountValue')->default(0);
            $table->string('discountType', 10);
            $table->string('maxDiscountValue', 10);
            $table->string('neverEndDate')->nullable();
            $table->timestamp('startDate');
            $table->timestamp('endDate')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
