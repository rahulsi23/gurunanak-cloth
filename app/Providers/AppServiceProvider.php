<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        if (config('app.env') === 'production' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Clean and align About/Contact navigation links database records
        try {
            if (Schema::hasTable('navigation_menus')) {
                \App\Models\NavigationMenu::where(function($q) {
                    $q->where('menu_type', 'header')->orWhereNull('menu_type');
                })->whereIn('label', ['About', 'Contact', 'About Us', 'Contact Us'])->delete();

                $footerCol = \App\Models\NavigationMenu::where('menu_type', 'footer')
                    ->whereNull('parent_id')
                    ->where('label', 'Company')
                    ->first();

                if (!$footerCol) {
                    $footerCol = \App\Models\NavigationMenu::where('menu_type', 'footer')
                        ->whereNull('parent_id')
                        ->whereIn('label', ['Quick Links', 'Help'])
                        ->first();
                }

                if (!$footerCol) {
                    $footerCol = \App\Models\NavigationMenu::create([
                        'label' => 'Company',
                        'url' => '#',
                        'menu_type' => 'footer',
                        'is_active' => true,
                        'sort_order' => 1
                    ]);
                }

                \App\Models\NavigationMenu::updateOrCreate(
                    [
                        'parent_id' => $footerCol->id,
                        'label' => 'About Us',
                        'menu_type' => 'footer'
                    ],
                    [
                        'url' => '/about',
                        'is_active' => true,
                        'sort_order' => 1
                    ]
                );

                \App\Models\NavigationMenu::updateOrCreate(
                    [
                        'parent_id' => $footerCol->id,
                        'label' => 'Contact Us',
                        'menu_type' => 'footer'
                    ],
                    [
                        'url' => '/contact',
                        'is_active' => true,
                        'sort_order' => 2
                    ]
                );

                \App\Models\NavigationMenu::updateOrCreate(
                    [
                        'parent_id' => $footerCol->id,
                        'label' => 'Bespoke Journal',
                        'menu_type' => 'footer'
                    ],
                    [
                        'url' => '/blogs',
                        'is_active' => true,
                        'sort_order' => 3
                    ]
                );
            }
        } catch (\Exception $e) {
            // Silence
        }

        // Auto-heal and align social_gallery section with dynamic button options
        try {
            if (Schema::hasTable('home_page_sections')) {
                $socialSection = \App\Models\HomePageSection::where('section_type', 'social_gallery')->first();
                if ($socialSection) {
                    $c = $socialSection->content;
                    $updated = false;
                    if (!isset($c['button_text'])) {
                        $c['button_text'] = 'Join Our Community';
                        $updated = true;
                    }
                    if (!isset($c['button_url'])) {
                        $c['button_url'] = 'https://instagram.com/gurunanakfashion';
                        $updated = true;
                    }
                    if ($updated) {
                        $socialSection->update(['content' => $c]);
                    }
                }
            }
        } catch (\Exception $e) {
            // Silence
        }

        // Share active multi-tier navigation menus globally with all frontend views safely
        try {
            if (Schema::hasTable('navigation_menus')) {
                $menus = \App\Models\NavigationMenu::where('is_active', true)
                    ->where('menu_type', 'header')
                    ->whereNull('parent_id')
                    ->with('children')
                    ->orderBy('sort_order')
                    ->get();
                \Illuminate\Support\Facades\View::share('menus', $menus);

                $footerMenus = \App\Models\NavigationMenu::where('is_active', true)
                    ->where('menu_type', 'footer')
                    ->whereNull('parent_id')
                    ->with('children')
                    ->orderBy('sort_order')
                    ->get();
                \Illuminate\Support\Facades\View::share('footerMenus', $footerMenus);
            }
        } catch (\Exception $e) {
            // Silence any pre-migration database exceptions
        }

        // Share cached store settings globally with all frontend views safely
        try {
            if (Schema::hasTable('store_settings')) {
                $settings = \Illuminate\Support\Facades\Cache::rememberForever('store_settings', function () {
                    return \App\Models\StoreSetting::all()->pluck('value', 'key')->toArray();
                });
                \Illuminate\Support\Facades\View::share('settings', $settings);

                // Dynamically bind SMTP settings from database to Laravel Mail config at runtime
                if (!empty($settings['mail_host'])) {
                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.transport' => 'smtp',
                        'mail.mailers.smtp.host' => $settings['mail_host'],
                        'mail.mailers.smtp.port' => $settings['mail_port'] ?? 587,
                        'mail.mailers.smtp.username' => $settings['mail_username'] ?? '',
                        'mail.mailers.smtp.password' => $settings['mail_password'] ?? '',
                        'mail.mailers.smtp.encryption' => ($settings['mail_encryption'] ?? 'TLS') === 'None' ? null : strtolower($settings['mail_encryption'] ?? 'tls'),
                        'mail.from.address' => $settings['mail_username'] ?? '',
                        'mail.from.name' => $settings['mail_from_name'] ?? 'Gurunanak Cloth',
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silence database Exceptions
        }

        // Share active Sales Channels globally with all storefront views safely
        try {
            if (Schema::hasTable('sales_channels')) {
                $salesChannels = \App\Models\SalesChannel::all();
                \Illuminate\Support\Facades\View::share('salesChannels', $salesChannels);
            }
        } catch (\Exception $e) {
            // Silence database Exceptions
        }


        // Share page-specific SEO configurations dynamically using fast cached query lookups
        try {
            if (Schema::hasTable('page_seos')) {
                \Illuminate\Support\Facades\View::composer('*', function ($view) {
                    if (array_key_exists('pageSeo', $view->getData())) {
                        return;
                    }
                    if (!app()->runningInConsole()) {
                        $path = request()->path();
                        $pageKey = null;

                        if ($path === '/' || $path === '') {
                            $pageKey = 'home';
                        } elseif ($path === 'shop' || str_starts_with($path, 'shop/')) {
                            $pageKey = 'shop';
                        } elseif ($path === 'checkout' || str_starts_with($path, 'checkout/')) {
                            $pageKey = 'checkout';
                        } elseif ($path === 'about') {
                            $pageKey = 'about';
                        } elseif ($path === 'contact') {
                            $pageKey = 'contact';
                        } elseif (str_starts_with($path, 'collection/')) {
                            $segments = explode('/', $path);
                            if (isset($segments[1])) {
                                $pageKey = $segments[1];
                            }
                        }

                        $settings = \Illuminate\Support\Facades\Cache::get('store_settings', []);
                        $pageSeo = null;

                        if ($pageKey) {
                            $pageSeo = \Illuminate\Support\Facades\Cache::remember('seo_' . $pageKey, 3600, function () use ($pageKey) {
                                $model = \App\Models\PageSeo::where('page_key', $pageKey)->first();
                                return $model ? $model->toArray() : null;
                            });
                            
                            if (is_object($pageSeo)) {
                                if (get_class($pageSeo) === '__PHP_Incomplete_Class') {
                                    $pageSeo = null;
                                } else {
                                    $pageSeo = (object) $pageSeo->toArray();
                                }
                            } elseif (is_array($pageSeo)) {
                                $pageSeo = (object) $pageSeo;
                            }
                        }

                        // Build dynamic editorial fallback object if page SEO is not configured yet
                        if (!$pageSeo) {
                            $pageSeo = new \stdClass();
                            $pageSeo->meta_title = 'GURUNANAK - Premium Luxury Clothing & Apparel';
                            $pageSeo->meta_description = 'Discover minimal luxury clothing designed with Apple-style cleanliness and editorial presentation. Shop premium high-end fashion, outerwear, and modern bespoke collections.';
                            $pageSeo->meta_keywords = 'fashion, luxury, clothing, apparel, gurunanak';
                            $pageSeo->og_title = 'GURUNANAK - Premium Luxury Clothing & Apparel';
                            $pageSeo->og_description = 'Discover minimal luxury clothing designed with Apple-style cleanliness and editorial presentation.';
                            $pageSeo->og_image = '';
                        }

                        // Cascade: If specific page has no social image, fall back to global OG Image
                        if (empty($pageSeo->og_image) && !empty($settings['og_image'])) {
                            $pageSeo->og_image = asset('storage/' . $settings['og_image']);
                        }

                        $view->with('pageSeo', $pageSeo);
                    }
                });
            }
        } catch (\Exception $e) {
            // Silence database exceptions during boot phase
        }
    }
}
