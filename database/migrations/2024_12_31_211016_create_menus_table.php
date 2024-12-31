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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->default(0);
            $table->bigInteger('menu_catalogue_id')->unsigned()->nullable();
            $table->foreign('menu_catalogue_id')->references('id')->on('menu_catalogues')->onDelete('set null');
            $table->integer('lft')->default(0);
            $table->integer('rgt')->default(0);
            $table->integer('level')->default(0);
            $table->string('type', 20)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('icon', 191)->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('publish')->default(1);
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
        Schema::dropIfExists('menus');
    }
};
