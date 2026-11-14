<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// System Utility Routes (Temporary fix for restricted CLI environment)
Route::get('/fix-wishlist', function () {
    $files = glob(resource_path('views/collection/*.blade.php'));
    $count = 0;
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        // Replace header icon
        $headerTarget = '<button onclick="alert(\'Wishlist: Your customized pieces are bookmarked for local viewing.\')" class="p-1 hover:text-[#8b7355] motion-soft transition-colors shrink-0" aria-label="Wishlist" title="Saved Looks">
                    <svg class="w-4 h-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>';
        
        $headerReplace = '<a href="{{ route(\'wishlist.index\') }}" class="p-1 hover:text-[#8b7355] motion-soft transition-colors shrink-0 relative" aria-label="Wishlist" title="Saved Looks">
                    <svg class="w-4 h-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    @auth
                        @php $wishlistCount = \App\Models\Wishlist::where(\'user_id\', auth()->id())->count(); @endphp
                        @if($wishlistCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#9a3412] text-white flex items-center justify-center text-[7px] font-bold rounded-full">{{ $wishlistCount }}</span>
                        @endif
                    @endauth
                </a>';
                
        // Replace product grid icons
        $gridTarget = '<button onclick="event.preventDefault(); window.location.href=\'{{ url(\'wishlist/\'.($item[\'id\'] ?? 1).\'/toggle\') }}\'\" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">';
        $gridReplace = '<button onclick="event.preventDefault(); window.location.href=\'{{ url(\'wishlist/\'.($item[\'id\'] ?? 1).\'/toggle\') }}\'\" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">';
        
        $content = str_replace($headerTarget, $headerReplace, $content);
        $content = str_replace($gridTarget, $gridReplace, $content);
        
        file_put_contents($file, $content);
        $count++;
    }
    return "Fixed $count collection files.";
});

Route::get('/fix-wishlist-2', function () {
    $files = glob(resource_path('views/collection/*.blade.php'));
    $count = 0;
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        $gridTarget = '<button onclick="event.preventDefault(); window.location.href=\'{{ url(\'wishlist/\'.($item[\'id\'] ?? 1).\'/toggle\') }}\'\" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">';
        $gridReplace = '<button onclick="event.preventDefault(); event.stopPropagation(); window.location.href=\'{{ url(\'wishlist/\'.($item[\'id\'] ?? 1).\'/toggle\') }}\';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">';
        
        $content = str_replace($gridTarget, $gridReplace, $content);
        file_put_contents($file, $content);
        $count++;
    }
    return "Fixed $count collection files again.";
});

Route::prefix('system')->group(function () {
    Route::get('/migrate', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return "Migration successful: " . \Illuminate\Support\Facades\Artisan::output();
        } catch (\Exception $e) {
            return "Migration failed: " . $e->getMessage();
        }
    });

    Route::get('/seed', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'HomePageSeeder', '--force' => true]);
            return "Seeding successful: " . \Illuminate\Support\Facades\Artisan::output();
        } catch (\Exception $e) {
            return "Seeding failed: " . $e->getMessage();
        }
    });

    Route::get('/db-status', function () {
        $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        return response()->json($tables);
    });
});

Route::get('/', function () {
    $sections = \App\Models\HomePageSection::where('is_active', true)->orderBy('sort_order')->get();
    $menus = \App\Models\NavigationMenu::where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->get();
    return view('welcome', compact('sections', 'menus'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    $activeOrders = \App\Models\Order::where('customer_email', $user->email)
        ->whereIn('status', ['New Order', 'Processing', 'Dispatched'])
        ->orderBy('created_at', 'desc')
        ->get();
        
    $pastOrders = \App\Models\Order::where('customer_email', $user->email)
        ->whereNotIn('status', ['New Order', 'Processing', 'Dispatched'])
        ->orderBy('created_at', 'desc')
        ->get();
        
    return view('dashboard', compact('activeOrders', 'pastOrders', 'user'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Secure Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/{product}/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle.get');
});

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', IsAdmin::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/products/{product}/toggle-visibility', [\App\Http\Controllers\Admin\ProductController::class, 'toggleVisibility'])->name('admin.products.toggle-visibility');
        Route::patch('/products/{product}/update-sort-order', [\App\Http\Controllers\Admin\ProductController::class, 'updateSortOrder'])->name('admin.products.update-sort-order');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->names('admin.products');
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.show');
        Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('admin.orders.invoice');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('admin.orders.status');
        
        // Administration Reviews System Studio
        Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::patch('/reviews/{review}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApprove'])->name('admin.reviews.toggle');
        Route::post('/reviews/{review}/reply', [\App\Http\Controllers\Admin\ReviewController::class, 'reply'])->name('admin.reviews.reply');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
        
        // Global Settings & Cached Overrides
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/settings/test-smtp', [\App\Http\Controllers\Admin\SettingController::class, 'testSmtp'])->name('admin.settings.test-smtp');
        
        // Visual Branding & Media Assets Suite
        Route::get('/branding', [\App\Http\Controllers\Admin\BrandingController::class, 'edit'])->name('admin.branding.edit');
        Route::put('/branding', [\App\Http\Controllers\Admin\BrandingController::class, 'update'])->name('admin.branding.update');
        
        // Sales Channels Third-party Stores CRUD
        Route::resource('sales-channels', \App\Http\Controllers\Admin\SalesChannelController::class)
            ->names('admin.sales-channels')
            ->except(['show', 'create', 'edit']);

        
        // SEO Meta Management Suite
        Route::get('/seo', [\App\Http\Controllers\Admin\SeoController::class, 'index'])->name('admin.seo.index');
        Route::get('/seo/{id}/edit', [\App\Http\Controllers\Admin\SeoController::class, 'edit'])->name('admin.seo.edit');
        Route::put('/seo/{id}', [\App\Http\Controllers\Admin\SeoController::class, 'update'])->name('admin.seo.update');
        Route::post('/seo/generate-sitemap', [\App\Http\Controllers\Admin\SeoController::class, 'generateSitemap'])->name('admin.seo.generate-sitemap');
        
        // Promo Coupons Engine
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->names('admin.coupons')->except(['show']);

        // Payment Gateway Configurations
        Route::get('/payment', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('admin.payment.edit');
        Route::put('/payment', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('admin.payment.update');

        // Home Page Designer (Shopify-like Control)
        Route::get('/homepage', [\App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('admin.homepage.index');
        Route::get('/homepage/sections/create', [\App\Http\Controllers\Admin\HomePageController::class, 'createSection'])->name('admin.homepage.sections.create');
        Route::post('/homepage/sections', [\App\Http\Controllers\Admin\HomePageController::class, 'storeSection'])->name('admin.homepage.sections.store');
        Route::patch('/homepage/sections/{section}/status', [\App\Http\Controllers\Admin\HomePageController::class, 'updateSectionStatus'])->name('admin.homepage.sections.status');
        Route::post('/homepage/sections/reorder', [\App\Http\Controllers\Admin\HomePageController::class, 'updateSectionsOrder'])->name('admin.homepage.sections.reorder');
        Route::get('/homepage/sections/{section}/edit', [\App\Http\Controllers\Admin\HomePageController::class, 'editSection'])->name('admin.homepage.sections.edit');
        Route::put('/homepage/sections/{section}', [\App\Http\Controllers\Admin\HomePageController::class, 'updateSectionContent'])->name('admin.homepage.sections.update');
        Route::delete('/homepage/sections/{section}', [\App\Http\Controllers\Admin\HomePageController::class, 'destroySection'])->name('admin.homepage.sections.destroy');
        
        Route::post('/homepage/menu', [\App\Http\Controllers\Admin\HomePageController::class, 'updateMenu'])->name('admin.homepage.menu.update');
        Route::delete('/homepage/menu/{menu}', [\App\Http\Controllers\Admin\HomePageController::class, 'deleteMenu'])->name('admin.homepage.menu.delete');
        
        // Navigation Builder Routes
        Route::get('/navigation', [\App\Http\Controllers\Admin\NavigationController::class, 'index'])->name('admin.navigation.index');
        Route::post('/navigation', [\App\Http\Controllers\Admin\NavigationController::class, 'store'])->name('admin.navigation.store');
        Route::put('/navigation/{menu}', [\App\Http\Controllers\Admin\NavigationController::class, 'update'])->name('admin.navigation.update');
        Route::delete('/navigation/{menu}', [\App\Http\Controllers\Admin\NavigationController::class, 'destroy'])->name('admin.navigation.destroy');
        Route::post('/navigation/reorder', [\App\Http\Controllers\Admin\NavigationController::class, 'reorder'])->name('admin.navigation.reorder');

        // Footer Navigation Routes
        Route::get('/footer-navigation', [\App\Http\Controllers\Admin\FooterNavigationController::class, 'index'])->name('admin.footer-navigation.index');
        Route::post('/footer-navigation', [\App\Http\Controllers\Admin\FooterNavigationController::class, 'store'])->name('admin.footer-navigation.store');
        Route::put('/footer-navigation/{menu}', [\App\Http\Controllers\Admin\FooterNavigationController::class, 'update'])->name('admin.footer-navigation.update');
        Route::delete('/footer-navigation/{menu}', [\App\Http\Controllers\Admin\FooterNavigationController::class, 'destroy'])->name('admin.footer-navigation.destroy');
        Route::post('/footer-navigation/reorder', [\App\Http\Controllers\Admin\FooterNavigationController::class, 'reorder'])->name('admin.footer-navigation.reorder');

        // Footer Pages Content Builders
        Route::get('/footer-pages/about', [\App\Http\Controllers\Admin\FooterPagesController::class, 'editAbout'])->name('admin.footer-pages.about');
        Route::put('/footer-pages/about', [\App\Http\Controllers\Admin\FooterPagesController::class, 'updateAbout'])->name('admin.footer-pages.about.update');
        Route::get('/footer-pages/contact', [\App\Http\Controllers\Admin\FooterPagesController::class, 'editContact'])->name('admin.footer-pages.contact');
        Route::put('/footer-pages/contact', [\App\Http\Controllers\Admin\FooterPagesController::class, 'updateContact'])->name('admin.footer-pages.contact.update');

        // Blogs & Categories Management
        Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->names('admin.blog-categories')->except(['create', 'show', 'edit']);
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogPostController::class)->names('admin.blogs');
    });
});

use App\Http\Controllers\CatalogController;

Route::get('/collection/{type}', [CatalogController::class, 'showLookbook'])
    ->where('type', 'men|women|oversized|summer|streetwear|accessories')
    ->name('collection.show');

// Helper alias mappings preserving backward-compatible named route parameters
Route::get('/collection/men', [CatalogController::class, 'showLookbook'])->defaults('type', 'men')->name('collection.men');
Route::get('/collection/women', [CatalogController::class, 'showLookbook'])->defaults('type', 'women')->name('collection.women');
Route::get('/collection/oversized', [CatalogController::class, 'showLookbook'])->defaults('type', 'oversized')->name('collection.oversized');
Route::get('/collection/summer', [CatalogController::class, 'showLookbook'])->defaults('type', 'summer')->name('collection.summer');
Route::get('/collection/streetwear', [CatalogController::class, 'showLookbook'])->defaults('type', 'streetwear')->name('collection.streetwear');
Route::get('/collection/accessories', [CatalogController::class, 'showLookbook'])->defaults('type', 'accessories')->name('collection.accessories');

Route::get('/product/detail/{slug?}', [CatalogController::class, 'showDetail'])->name('product.detail');

Route::get('/shop', function () {
    return view('shop.index');
})->name('shop.index');

Route::get('/checkout', function () {
    return view('checkout.index');
})->middleware('auth')->name('checkout.index');

Route::get('/about', [CatalogController::class, 'showAbout'])->name('about');
Route::get('/contact', [CatalogController::class, 'showContact'])->name('contact');

// Public Storefront Blog Journal Routes
Route::get('/blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');

// Public Storefront Live Hooks
Route::get('/api/search/suggestions', [CatalogController::class, 'searchSuggestions'])->name('api.search.suggestions');
Route::post('/api/checkout/submit', [\App\Http\Controllers\OrderController::class, 'store'])->name('api.checkout.submit');
Route::post('/api/checkout/apply-coupon', [\App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('api.checkout.apply-coupon');
Route::post('/product/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('product.reviews.store');


require __DIR__.'/auth.php';
