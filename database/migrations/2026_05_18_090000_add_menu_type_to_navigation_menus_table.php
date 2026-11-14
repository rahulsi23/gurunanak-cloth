<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add menu_type column to navigation_menus
        Schema::table('navigation_menus', function (Blueprint $table) {
            $table->string('menu_type')->default('header')->after('is_active')->index();
        });

        // 2. Seed default Footer Columns & Links
        // Column 1: Quick Links
        $quickLinksId = DB::table('navigation_menus')->insertGetId([
            'label' => 'Quick Links',
            'url' => '#',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
            'menu_type' => 'footer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $quickLinks = [
            ['label' => 'Shop Catalog', 'url' => '/shop'],
            ['label' => 'Our Story', 'url' => '/#about'],
            ['label' => 'Reviews', 'url' => '/#reviews'],
            ['label' => 'Track Order', 'url' => '/#'],
        ];

        foreach ($quickLinks as $idx => $link) {
            DB::table('navigation_menus')->insert([
                'label' => $link['label'],
                'url' => $link['url'],
                'parent_id' => $quickLinksId,
                'sort_order' => $idx + 1,
                'is_active' => true,
                'menu_type' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Column 2: Collections
        $collectionsId = DB::table('navigation_menus')->insertGetId([
            'label' => 'Collections',
            'url' => '#',
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
            'menu_type' => 'footer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $collections = [
            ['label' => 'New Arrivals', 'url' => '/#new-arrivals'],
            ['label' => 'Best Sellers', 'url' => '/#best-sellers'],
            ['label' => 'Summer Collection', 'url' => '/#promotional'],
            ['label' => 'Accessories', 'url' => '/#categories'],
        ];

        foreach ($collections as $idx => $link) {
            DB::table('navigation_menus')->insert([
                'label' => $link['label'],
                'url' => $link['url'],
                'parent_id' => $collectionsId,
                'sort_order' => $idx + 1,
                'is_active' => true,
                'menu_type' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Delete seeded footer menus first
        DB::table('navigation_menus')->where('menu_type', 'footer')->delete();

        Schema::table('navigation_menus', function (Blueprint $table) {
            $table->dropColumn('menu_type');
        });
    }
};
