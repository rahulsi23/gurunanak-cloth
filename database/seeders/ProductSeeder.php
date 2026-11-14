<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Categories per Lookbook
        $categories = [
            // Women
            ['name' => 'Blouses', 'slug' => 'blouses', 'lookbook' => 'women'],
            ['name' => 'Dresses', 'slug' => 'dresses', 'lookbook' => 'women'],
            ['name' => 'Knitwear', 'slug' => 'knitwear', 'lookbook' => 'women'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'lookbook' => 'women'],

            // Men
            ['name' => 'Tailoring', 'slug' => 'suits', 'lookbook' => 'men'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'lookbook' => 'men'],
            ['name' => 'Knitwear', 'slug' => 'knitwear', 'lookbook' => 'men'],
            ['name' => 'Shirts', 'slug' => 'shirts', 'lookbook' => 'men'],

            // Summer
            ['name' => 'Linens', 'slug' => 'linens', 'lookbook' => 'summer'],
            ['name' => 'Swimwear', 'slug' => 'swimwear', 'lookbook' => 'summer'],
            ['name' => 'Sundresses', 'slug' => 'sundresses', 'lookbook' => 'summer'],
            ['name' => 'Resort Essentials', 'slug' => 'accessories', 'lookbook' => 'summer'],

            // Streetwear
            ['name' => 'Hoodies', 'slug' => 'hoodies', 'lookbook' => 'streetwear'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'lookbook' => 'streetwear'],
            ['name' => 'Trousers', 'slug' => 'trousers', 'lookbook' => 'streetwear'],

            // Oversized
            ['name' => 'Jackets', 'slug' => 'jackets', 'lookbook' => 'oversized'],
            ['name' => 'Knitwear', 'slug' => 'knitwear', 'lookbook' => 'oversized'],
            ['name' => 'Shirts', 'slug' => 'shirts', 'lookbook' => 'oversized'],

            // Accessories
            ['name' => 'Handbags', 'slug' => 'handbags', 'lookbook' => 'accessories'],
            ['name' => 'Eyewear', 'slug' => 'eyewear', 'lookbook' => 'accessories'],
            ['name' => 'Scarves', 'slug' => 'scarves', 'lookbook' => 'accessories'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug'], 'lookbook' => $cat['lookbook']], $cat);
        }

        // 2. Seed High-Fidelity Products
        $products = [
            // --- WOMEN ---
            [
                'title' => 'Minimalist Core Trench',
                'slug' => 'women-trench-1',
                'subtitle' => 'Outerwear Studio',
                'price' => 290.00,
                'image_path' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80',
                'lookbook' => 'women',
                'category_slug' => 'outerwear',
                'sizes' => ['XS', 'S', 'M'],
                'description' => 'Breathable organic structure offering superior drape and weather presence.',
            ],
            [
                'title' => 'Refined Raw Silk Blouse',
                'slug' => 'women-blouse-1',
                'subtitle' => 'Blouses Atelier',
                'price' => 140.00,
                'image_path' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=600&q=80',
                'lookbook' => 'women',
                'category_slug' => 'blouses',
                'sizes' => ['S', 'M', 'L'],
                'description' => 'Delicate pure mulberry thread finished with minimalist concealed plackets.',
            ],
            [
                'title' => 'Structured Column Dress',
                'slug' => 'women-dress-1',
                'subtitle' => 'Dresses Atelier',
                'price' => 310.00,
                'image_path' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80',
                'lookbook' => 'women',
                'category_slug' => 'dresses',
                'sizes' => ['XS', 'S', 'M'],
                'description' => 'Architectural columnar line emphasizing seamless natural geometry.',
            ],
            [
                'title' => 'Heavy Ribbed Cashmere Knit',
                'slug' => 'women-knit-1',
                'subtitle' => 'Knitwear Studio',
                'price' => 240.00,
                'image_path' => 'https://images.unsplash.com/photo-1434389678232-0402b9781682?auto=format&fit=crop&w=600&q=80',
                'lookbook' => 'women',
                'category_slug' => 'knitwear',
                'sizes' => ['S', 'M'],
                'description' => 'Ultra-soft hand-loomed grade 1 cashmere fibers optimized for layering.',
            ],

            // --- MEN ---
            [
                'title' => 'Bespoke Double-Breasted Jacket',
                'slug' => 'men-suit-1',
                'subtitle' => 'Tailoring Atelier',
                'price' => 450.00,
                'image_path' => 'https://images.pexels.com/photos/3760854/pexels-photo-3760854.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'men',
                'category_slug' => 'suits',
                'sizes' => ['48', '50', '52'],
                'description' => 'Sharp Neapolitan shoulder line handcrafted using premium fine Italian merino.',
            ],
            [
                'title' => 'Heavy Wool Overcoat',
                'slug' => 'men-outerwear-1',
                'subtitle' => 'Outerwear Studio',
                'price' => 520.00,
                'image_path' => 'https://images.pexels.com/photos/297933/pexels-photo-297933.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'men',
                'category_slug' => 'outerwear',
                'sizes' => ['50', '52', '54'],
                'description' => 'Dense protective Melton wool weave structure delivering absolute thermal retention.',
            ],
            [
                'title' => 'Minimalist Cable Sweater',
                'slug' => 'men-knit-1',
                'subtitle' => 'Knitwear Atelier',
                'price' => 195.00,
                'image_path' => 'https://images.pexels.com/photos/45982/pexels-photo-45982.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'men',
                'category_slug' => 'knitwear',
                'sizes' => ['M', 'L', 'XL'],
                'description' => 'Traditional dense fisherman stitch re-engineered with clean soft margins.',
            ],

            // --- SUMMER ---
            [
                'title' => 'Pure Resort Linen Tunic',
                'slug' => 'summer-linen-1',
                'subtitle' => 'Linens Edition',
                'price' => 125.00,
                'image_path' => 'https://images.pexels.com/photos/1036622/pexels-photo-1036622.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'summer',
                'category_slug' => 'linens',
                'sizes' => ['S', 'M', 'L'],
                'description' => 'Lightweight raw flax spun into breezy loose leisure volumes.',
            ],
            [
                'title' => 'Silk Plissé Halter Sundress',
                'slug' => 'summer-sundress-1',
                'subtitle' => 'Sundresses Collection',
                'price' => 280.00,
                'image_path' => 'https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'summer',
                'category_slug' => 'sundresses',
                'sizes' => ['XS', 'S', 'M'],
                'description' => 'Sun-drenched dynamic pleats engineered for striking evening poolside silhouettes.',
            ],

            // --- STREETWEAR ---
            [
                'title' => 'Minimalist Core Oversize Hoodie',
                'slug' => 'streetwear-hoodie-1',
                'subtitle' => 'Hoodies Atelier',
                'price' => 160.00,
                'image_path' => 'https://images.pexels.com/photos/1183266/pexels-photo-1183266.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'streetwear',
                'category_slug' => 'hoodies',
                'sizes' => ['M', 'L', 'XL'],
                'description' => 'Heavyweight 500gsm brushed loopback jersey complete with signature drop drop shoulder.',
            ],
            [
                'title' => 'Urban Utility Jacket',
                'slug' => 'streetwear-jacket-1',
                'subtitle' => 'Outerwear Lab',
                'price' => 290.00,
                'image_path' => 'https://images.pexels.com/photos/1036623/pexels-photo-1036623.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'streetwear',
                'category_slug' => 'outerwear',
                'sizes' => ['L', 'XL'],
                'description' => 'Technical washed garment-dyed nylon housing optimized multi-angle internal access vector storage.',
            ],

            // --- OVERSIZED ---
            [
                'title' => 'Boxy Structured Coat',
                'slug' => 'oversized-coat-1',
                'subtitle' => 'Tailored Volumes',
                'price' => 340.00,
                'image_path' => 'https://images.pexels.com/photos/9558577/pexels-photo-9558577.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'oversized',
                'category_slug' => 'jackets',
                'sizes' => ['OS', 'L/XL'],
                'description' => 'Dramatic architectural drop lines maximizing contemporary overlay dominance.',
            ],
            [
                'title' => 'Heavy Knit Oversized Sweater',
                'slug' => 'oversized-knit-1',
                'subtitle' => 'Knitwear Studio',
                'price' => 190.00,
                'image_path' => 'https://images.pexels.com/photos/1126993/pexels-photo-1126993.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'oversized',
                'category_slug' => 'knitwear',
                'sizes' => ['OS'],
                'description' => 'Loose soft gauge weave structure bringing maximum comfort ease.',
            ],

            // --- ACCESSORIES ---
            [
                'title' => 'Structured Grain Handbag',
                'slug' => 'accessories-bag-1',
                'subtitle' => 'Leather Goods',
                'price' => 380.00,
                'image_path' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'accessories',
                'category_slug' => 'handbags',
                'sizes' => ['OS'],
                'description' => 'Sculptural top-handle profile finished with matching polished gold structural clasps.',
            ],
            [
                'title' => 'Minimalist Core Eyewear',
                'slug' => 'accessories-eyewear-1',
                'subtitle' => 'Eyewear Studio',
                'price' => 165.00,
                'image_path' => 'https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600',
                'lookbook' => 'accessories',
                'category_slug' => 'eyewear',
                'sizes' => ['OS'],
                'description' => 'Thick lightweight acetate block components delivering classic aesthetic shielding.',
            ]
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(['slug' => $prod['slug']], $prod);
        }
    }
}
