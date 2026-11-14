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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('is_featured');
            $table->integer('sort_order')->default(999)->after('is_visible');
            $table->string('color')->nullable()->after('sort_order');
            $table->string('size')->nullable()->after('color');
            $table->text('mesh_ids')->nullable()->after('size'); // Stores JSON array of related product IDs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_visible', 'sort_order', 'color', 'size', 'mesh_ids']);
        });
    }
};
