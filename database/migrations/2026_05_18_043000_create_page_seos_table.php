<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_seos', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('page_name');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        // Seed premium day-one high-fidelity default records
        $defaultSeos = [
            [
                'page_key' => 'home',
                'page_name' => 'Home Page',
                'meta_title' => 'GURUNANAK - Premium Minimalist Luxury Clothing & Bespoke Fashion',
                'meta_description' => 'Discover minimal luxury clothing designed with Apple-style cleanliness and editorial presentation. Shop premium high-end fashion, outerwear, and modern bespoke collections.',
                'meta_keywords' => 'luxury clothing, bespoke fashion, minimalist streetwear, high-end knitwear, wool coat',
                'og_title' => 'GURUNANAK - Premium Minimalist Luxury Clothing',
                'og_description' => 'Discover minimal luxury clothing designed with Apple-style cleanliness and editorial presentation.',
                'og_image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'men',
                'page_name' => "Men's Collection",
                'meta_title' => 'Men Collection | GURUNANAK Minimalist Luxury Studio',
                'meta_description' => 'Explore structured wool blazers, premium cashmere sweaters, and high-performance trench coats engineered for the modern luxury wardrobe.',
                'meta_keywords' => 'mens designer clothing, bespoke tailoring, mens premium knitwear, luxury trench coats',
                'og_title' => "Men's Collection | GURUNANAK Studio",
                'og_description' => 'Structured wool blazers, premium cashmere sweaters, and high-performance trench coats.',
                'og_image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'women',
                'page_name' => "Women's Collection",
                'meta_title' => 'Women Collection | GURUNANAK Bespoke Atelier',
                'meta_description' => 'Browse double-breasted minimalist wool coats, raw silk drape blouses, and column dresses tailored with premium materials.',
                'meta_keywords' => 'womens designer wear, bespoke silk blouse, wool coats, column dresses',
                'og_title' => "Women's Collection | GURUNANAK Atelier",
                'og_description' => 'Double-breasted minimalist wool coats, raw silk drape blouses, and column dresses.',
                'og_image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'oversized',
                'page_name' => 'Oversized Collection',
                'meta_title' => 'Oversized Fit Collection | GURUNANAK Couture',
                'meta_description' => 'Modern loose silhouettes, dropped shoulders, and heavyweight organic luxury loopback cotton pieces for effortless luxury comfort.',
                'meta_keywords' => 'oversized luxury street wear, minimalist hoodies, loopback cotton pieces, loose fit couture',
                'og_title' => 'Oversized Fit Collection | GURUNANAK',
                'og_description' => 'Modern loose silhouettes, dropped shoulders, and heavyweight organic cotton pieces.',
                'og_image' => 'https://images.unsplash.com/photo-1516826957135-700dedea698c?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'summer',
                'page_name' => 'Summer Resort Collection',
                'meta_title' => 'Summer Resort Wear | GURUNANAK Fine Collection',
                'meta_description' => 'Lightweight linen shirts, raw mulberry silk, and airy tailored trousers for effortless warm-weather elegance and resort style.',
                'meta_keywords' => 'summer luxury linen clothing, resort wear, silk shirts, breathable tailoring',
                'og_title' => 'Summer Resort Wear | GURUNANAK',
                'og_description' => 'Lightweight linen shirts, raw mulberry silk, and airy tailored trousers.',
                'og_image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'streetwear',
                'page_name' => 'Streetwear Collection',
                'meta_title' => 'Minimalist Streetwear | GURUNANAK Urban Division',
                'meta_description' => 'Premium loopback cotton hoodies, clean structured cargo trousers, and luxury essentials crafted with refined modern street craftsmanship.',
                'meta_keywords' => 'minimalist streetwear, luxury hoodies, cargo trousers, premium designer tees',
                'og_title' => 'Minimalist Streetwear | GURUNANAK Urban',
                'og_description' => 'Premium loopback cotton hoodies, clean structured cargo trousers, and luxury essentials.',
                'og_image' => 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'accessories',
                'page_name' => 'Accessories Collection',
                'meta_title' => 'Curated Accessories | GURUNANAK Accessories Studio',
                'meta_description' => 'Handcrafted Italian leather belts, minimal silk scarves, and timeless travel companions for complete editorial styling.',
                'meta_keywords' => 'designer accessories, premium leather belts, silk scarves, minimalist travel luggage',
                'og_title' => 'Curated Accessories | GURUNANAK Studio',
                'og_description' => 'Handcrafted Italian leather belts, minimal silk scarves, and timeless travel companions.',
                'og_image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'shop',
                'page_name' => 'Showroom Catalog',
                'meta_title' => 'Curated Showroom & Live Studio | GURUNANAK Catalog',
                'meta_description' => 'Filter and search our complete high-fidelity catalog of minimalist luxury garments using predictive autocomplete and cascading parameters.',
                'meta_keywords' => 'luxury search catalog, showroom garments, autocomplete fashion search',
                'og_title' => 'Curated Showroom & Live Studio | GURUNANAK',
                'og_description' => 'Filter and search our complete high-fidelity catalog of minimalist luxury garments.',
                'og_image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_key' => 'checkout',
                'page_name' => 'Checkout Portal',
                'meta_title' => 'Secure Checkout Portal | GURUNANAK Luxury Client Suite',
                'meta_description' => 'Finalize your curated collection with premium studio packaging and complimentary worldwide secure logistics.',
                'meta_keywords' => 'secure checkout, luxury shopping checkout, credit card checkout',
                'og_title' => 'Secure Checkout Portal | GURUNANAK',
                'og_description' => 'Finalize your curated collection with premium studio packaging and secure logistics.',
                'og_image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('page_seos')->insert($defaultSeos);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
