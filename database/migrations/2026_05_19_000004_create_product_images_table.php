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
        Schema::create('product_images', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $blueprint->string('image_path');
            $blueprint->integer('sort_order')->default(999);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
