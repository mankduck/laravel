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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('province_id', 10)->nullable();
            $table->string('district_id', 10)->nullable();
            $table->string('ward_id', 10)->nullable();
            $table->string('address')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('ip')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->bigInteger('customer_catalogue_id')->unsigned();
            $table->foreign('customer_catalogue_id')->references('id')->on('customer_catalogues')->onDelete('cascade');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
