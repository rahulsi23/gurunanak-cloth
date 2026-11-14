<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomePageSection;
use App\Models\NavigationMenu;
use App\Models\StoreSetting;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Store Settings
        $settings = [
            'logo_type' => 'text',
            'logo_text' => 'GURUNANAK',
            'logo_subtitle' => 'CLOTH HOUSE',
            'footer_logo_type' => 'text',
            'footer_logo_text' => 'GURUNANAK',
            'facebook_url' => 'https://facebook.com/gurunanak_cloth',
            'instagram_url' => 'https://instagram.com/gurunanak_cloth',
            'youtube_url' => 'https://youtube.com/gurunanak_cloth',
            'pinterest_url' => 'https://pinterest.com/gurunanak_cloth',
            'announcement_text' => '✨ FREE SHIPPING ON ORDERS OVER $150 &bull; SUMMER SALE: EXTRA 20% OFF AT CHECKOUT &bull; QUALITY PACKAGING ON ALL ORDERS &bull;',
            'hero_badge' => '✨ New Summer Collection',
            'hero_title' => 'Natural Fabrics. <br><span class="font-bold bg-gradient-to-r from-[#1c1917] via-[#431407] to-[#8b7355] bg-clip-text text-transparent">Honest Tailoring.</span>',
            'hero_subtitle' => 'Natural cotton, linen, and wool clothing made for everyday comfort. Thoughtfully stitched to last.',
            'whatsapp_phone' => '919876543210',
            'whatsapp_message' => 'Hi! I have a question about sizing and ordering from your store. Could you help me?',
            'whatsapp_color' => '#25d366',
            'whatsapp_pulse' => '1',
            'whatsapp_enabled' => '1',
        ];

        foreach ($settings as $key => $val) {
            StoreSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 1. Navigation Menus
        $menus = [
            ['label' => 'Home', 'url' => '/', 'sort_order' => 1],
            ['label' => 'Shop', 'url' => '/shop', 'sort_order' => 2],
            ['label' => 'Men', 'url' => '/collection/men', 'sort_order' => 3],
            ['label' => 'Women', 'url' => '/collection/women', 'sort_order' => 4],
            ['label' => 'New Arrivals', 'url' => '#new-arrivals', 'sort_order' => 5],
            ['label' => 'Collections', 'url' => '#promotional', 'sort_order' => 6],
            ['label' => 'Best Sellers', 'url' => '#best-sellers', 'sort_order' => 7],
            ['label' => 'About', 'url' => '#about', 'sort_order' => 8],
            ['label' => 'Contact', 'url' => '#footer', 'sort_order' => 9],
        ];

        foreach ($menus as $menu) {
            NavigationMenu::updateOrCreate(['label' => $menu['label']], $menu);
        }

        // 2. Home Page Sections
        $sections = [
            [
                'section_type' => 'hero',
                'title' => 'Hero Banner',
                'sort_order' => 1,
                'content' => [
                    'badge' => 'Summer Collection 2026',
                    'title' => 'Comfortable Clothes. <br><span class="font-bold text-white">Made to Last.</span>',
                    'subtitle' => 'Everyday cotton, linen, and silk pieces designed for comfort, ease of movement, and long-lasting wear.',
                    'button1_text' => 'Shop Now',
                    'button1_url' => '/shop',
                    'button2_text' => 'View Collections',
                    'button2_url' => '/shop',
                    'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=80',
                    'look_label' => 'New Season'
                ]
            ],
            [
                'section_type' => 'categories_grid',
                'title' => 'Featured Categories',
                'sort_order' => 2,
                'content' => [
                    'heading' => 'Shop by Category',
                    'subheading' => 'Our Collections',
                    'description' => 'Browse daily essentials, casual wear, and seasonal clothing.',
                    'categories' => [
                        ['name' => 'Men Collection', 'url' => '/collection/men', 'image' => 'https://images.unsplash.com/photo-1516826957135-700dedea698c?auto=format&fit=crop&w=800&q=80'],
                        ['name' => 'Women Collection', 'url' => '/collection/women', 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80'],
                        ['name' => 'Oversized Fashion', 'url' => '/collection/oversized', 'image' => 'https://images.pexels.com/photos/9558577/pexels-photo-9558577.jpeg?auto=compress&cs=tinysrgb&w=800'],
                        ['name' => 'Summer Collection', 'url' => '/collection/summer', 'image' => 'https://images.pexels.com/photos/1755428/pexels-photo-1755428.jpeg?auto=compress&cs=tinysrgb&w=800'],
                        ['name' => 'Streetwear', 'url' => '/collection/streetwear', 'image' => 'https://images.pexels.com/photos/1183266/pexels-photo-1183266.jpeg?auto=compress&cs=tinysrgb&w=800'],
                        ['name' => 'Accessories', 'url' => '/collection/accessories', 'image' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=800'],
                    ]
                ]
            ],
            [
                'section_type' => 'product_grid',
                'title' => 'New Arrivals',
                'sort_order' => 3,
                'content' => [
                    'heading' => 'New Arrivals',
                    'subheading' => 'Just In',
                    'description' => 'Our newest clothing pieces for the season, cut from breathable cotton and soft wool blends.',
                    'product_slugs' => ['coat', 'knitwear', 'blouse', 'blazer']
                ]
            ],
            [
                'section_type' => 'product_grid',
                'title' => 'Best Sellers',
                'sort_order' => 4,
                'content' => [
                    'heading' => 'Best Sellers',
                    'subheading' => 'Customer Favorites',
                    'description' => 'The pieces our customers wear and recommend the most.',
                    'product_slugs' => ['trench', 'crewneck', 'dress', 'trousers']
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => 'Summer Promo',
                'sort_order' => 5,
                'content' => [
                    'badge' => 'Summer Essentials',
                    'title' => 'Lightweight <br>Summer Wear.',
                    'subtitle' => 'Breathable linens and airy cottons made to keep you cool through warm summer afternoons.',
                    'button_text' => 'Explore Summer Styles',
                    'button_url' => '/shop',
                    'image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1600&q=80'
                ]
            ],
            [
                'section_type' => 'about',
                'title' => 'About Brand',
                'sort_order' => 6,
                'content' => [
                    'badge' => 'About Our Shop',
                    'title' => 'Honest Fabrics. <br> Fair Prices.',
                    'subtitle' => 'At Gurunanak Cloth House, we believe good clothing should be comfortable, reliable, and priced fairly.',
                    'description' => 'Since our early days, we have focused on quality weaving, neat stitching, and materials that wash well and stay comfortable year after year.',
                    'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1000&q=80',
                    'signature_text' => 'Gurunanak Cloth House',
                    'signature_sub' => 'Family Owned & Operated'
                ]
            ],
            [
                'section_type' => 'reviews',
                'title' => 'Customer Reviews',
                'sort_order' => 7,
                'content' => [
                    'heading' => 'Customer Reviews',
                    'subheading' => 'What Customers Say',
                    'reviews' => [
                        [
                            'name' => 'Elena Vargova',
                            'initials' => 'EV',
                            'role' => 'Verified Buyer',
                            'rating' => 5,
                            'comment' => '"The cotton shirt fits nicely and stays soft after several washes. Delivered in three days."'
                        ],
                        [
                            'name' => 'Christian Dubois',
                            'initials' => 'CD',
                            'role' => 'Verified Buyer',
                            'rating' => 5,
                            'comment' => '"Good stitching around the collar and sleeves. Sizing matches the chart accurately."'
                        ],
                        [
                            'name' => 'Siddharth Narang',
                            'initials' => 'SN',
                            'role' => 'Verified Buyer',
                            'rating' => 5,
                            'comment' => '"I bought two pairs of trousers. The fabric weight is solid and comfortable for work."'
                        ]
                    ]
                ]
            ],
            [
                'section_type' => 'social_gallery',
                'title' => 'Instagram Feed',
                'sort_order' => 8,
                'content' => [
                    'heading' => 'See How Customers Wear It',
                    'handle' => '@gurunanakfashion',
                    'button_text' => 'Follow on Instagram',
                    'button_url' => 'https://instagram.com/gurunanakfashion',
                    'images' => [
                        'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=80',
                    ]
                ]
            ]
        ];

        foreach ($sections as $section) {
            HomePageSection::updateOrCreate(
                ['sort_order' => $section['sort_order']],
                $section
            );
        }
    }
}
