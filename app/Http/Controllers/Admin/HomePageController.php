<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSection;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $sections = HomePageSection::orderBy('sort_order')->get();
        $categories = \App\Models\Category::all();
        $products = \App\Models\Product::all();
        
        $menus = NavigationMenu::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'label' => $menu->label,
                    'url' => $menu->url,
                    'children' => $menu->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'label' => $child->label,
                            'url' => $child->url,
                        ];
                    })->toArray(),
                ];
            });

        return view('admin.homepage.index', compact('sections', 'menus', 'categories', 'products'));
    }

    public function updateSectionStatus(HomePageSection $section, Request $request)
    {
        $section->update(['is_active' => $request->is_active]);
        return back()->with('success', 'Section status updated successfully.');
    }

    public function updateSectionsOrder(Request $request)
    {
        $orders = $request->input('order'); // Array of IDs in order
        foreach ($orders as $index => $id) {
            HomePageSection::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function createSection()
    {
        $types = [
            'hero' => 'Hero Banner',
            'banner' => 'Wide Banner',
            'product_grid' => 'Product Grid',
            'categories_grid' => 'Categories Grid',
            'reviews' => 'Customer Reviews',
            'about' => 'About Section',
            'social_gallery' => 'Social Gallery'
        ];
        return view('admin.homepage.create_section', compact('types'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'section_type' => 'required|string',
            'title' => 'required|string'
        ]);

        $defaultContent = [];
        switch ($request->section_type) {
            case 'hero':
                $defaultContent = [
                    'badge' => 'New Collection',
                    'title' => 'Elegance <br><span class="font-bold">Redefined.</span>',
                    'subtitle' => 'Discover minimal luxury clothing designed with Apple-style cleanliness.',
                    'button1_text' => 'Shop Now',
                    'button1_url' => '/shop',
                    'button2_text' => 'View Catalog',
                    'button2_url' => '/shop',
                    'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=80',
                    'look_label' => 'Look 01'
                ];
                break;
            case 'banner':
                $defaultContent = [
                    'title' => 'The Summer Edit',
                    'subtitle' => 'Lightweight fabrics for warm days.',
                    'button_text' => 'Explore',
                    'button_url' => '/shop',
                    'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e12?auto=format&fit=crop&w=1400&q=80'
                ];
                break;
            case 'product_grid':
                $defaultContent = [
                    'heading' => 'Featured Products',
                    'subheading' => 'Handpicked for you',
                    'description' => 'Our most popular pieces of the season.',
                    'product_slugs' => ['coat', 'knitwear', 'blouse', 'blazer']
                ];
                break;
            case 'categories_grid':
                $defaultContent = [
                    'heading' => 'Shop by Category',
                    'categories' => [
                        ['title' => 'Men', 'slug' => 'men', 'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d'],
                        ['title' => 'Women', 'slug' => 'women', 'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d']
                    ]
                ];
                break;
            case 'reviews':
                $defaultContent = [
                    'heading' => 'Client Testimonials',
                    'reviews' => [
                        ['name' => 'Sarah J.', 'comment' => 'The quality is unmatched. Truly luxury.', 'rating' => 5],
                        ['name' => 'Michael R.', 'comment' => 'Best fitting trousers I have ever owned.', 'rating' => 5]
                    ]
                ];
                break;
            case 'about':
                $defaultContent = [
                    'title' => 'Our Story',
                    'content' => 'Crafting excellence since 1990.',
                    'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8'
                ];
                break;
            case 'social_gallery':
                $defaultContent = [
                    'heading' => 'Follow Us on Instagram',
                    'images' => [
                        'https://images.unsplash.com/photo-1441984904996-e0b6ba687e12',
                        'https://images.unsplash.com/photo-1441986300917-64674bd600d8'
                    ]
                ];
                break;
        }

        $lastSection = HomePageSection::orderBy('sort_order', 'desc')->first();
        $order = $lastSection ? $lastSection->sort_order + 1 : 1;

        HomePageSection::create([
            'section_type' => $request->section_type,
            'title' => $request->title,
            'content' => $defaultContent,
            'sort_order' => $order,
            'is_active' => true
        ]);

        return redirect()->route('admin.homepage.index')->with('success', 'Section created successfully.');
    }

    public function editSection(HomePageSection $section)
    {
        $categories = \App\Models\Category::all();
        $products = \App\Models\Product::orderBy('title', 'asc')->get();
        return view('admin.homepage.edit_section', compact('section', 'categories', 'products'));
    }

    public function destroySection(HomePageSection $section)
    {
        $section->delete();
        return back()->with('success', 'Section deleted successfully.');
    }

    public function updateSectionContent(HomePageSection $section, Request $request)
    {
        $content = $request->input('content', []);
        $files = $request->file('content', []);

        // Handle File Uploads (Single, Arrays, and Nested Arrays)
        foreach ($files as $key => $file) {
            if (is_array($file)) {
                // Check if it's a simple array (gallery) or nested (categories)
                foreach ($file as $index => $subFile) {
                    if (is_array($subFile)) {
                        // Handle Nested (e.g. content[categories][0][image])
                        foreach ($subFile as $subKey => $f) {
                            if ($f) {
                                $path = $f->store('homepage', 'public');
                                $content[$key][$index][$subKey] = '/storage/' . $path;
                            }
                        }
                    } else if ($subFile) {
                        // Handle Simple Array (e.g. content[images][0])
                        $path = $subFile->store('homepage', 'public');
                        $content[$key][$index] = '/storage/' . $path;
                    }
                }
            } else if ($file) {
                // Handle Single image
                $path = $file->store('homepage', 'public');
                $content[$key] = '/storage/' . $path;
            }
        }
        
        // Handle JSON strings from textareas
        foreach ($content as $key => $value) {
            if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $content[$key] = $decoded;
                }
            }
        }

        // Dedicated sanitization for product_grid sections
        if ($section->section_type === 'product_grid') {
            if (!isset($content['product_slugs']) || !is_array($content['product_slugs'])) {
                $content['product_slugs'] = [];
            } else {
                $content['product_slugs'] = array_values(array_filter($content['product_slugs']));
            }
        }

        $section->update(['content' => $content]);
        
        return redirect()->route('admin.homepage.index')->with('success', 'Section content updated.');
    }

    public function updateMenu(Request $request)
    {
        $menus = $request->input('menus', []);
        
        // Track IDs to keep
        $keepIds = [];

        foreach ($menus as $index => $item) {
            $menu = null;
            if (isset($item['id'])) {
                $menu = NavigationMenu::find($item['id']);
                if ($menu) {
                    $menu->update([
                        'label' => $item['label'],
                        'url' => $item['url'],
                        'parent_id' => null, // Reset for top level
                        'sort_order' => $index + 1
                    ]);
                    $keepIds[] = $menu->id;
                }
            } else {
                $menu = NavigationMenu::create([
                    'label' => $item['label'],
                    'url' => $item['url'],
                    'sort_order' => $index + 1,
                    'is_active' => true
                ]);
                $keepIds[] = $menu->id;
            }

            // Handle Children
            if ($menu && isset($item['children'])) {
                foreach ($item['children'] as $childIndex => $childItem) {
                    if (isset($childItem['id'])) {
                        $child = NavigationMenu::find($childItem['id']);
                        if ($child) {
                            $child->update([
                                'label' => $childItem['label'],
                                'url' => $childItem['url'],
                                'parent_id' => $menu->id,
                                'sort_order' => $childIndex + 1
                            ]);
                            $keepIds[] = $child->id;
                        }
                    } else {
                        $child = NavigationMenu::create([
                            'label' => $childItem['label'],
                            'url' => $childItem['url'],
                            'parent_id' => $menu->id,
                            'sort_order' => $childIndex + 1,
                            'is_active' => true
                        ]);
                        $keepIds[] = $child->id;
                    }
                }
            }
        }

        // Delete menus not in the list (if needed, but usually we just want to remove what user clicked remove on)
        // NavigationMenu::whereNotIn('id', $keepIds)->delete();
        
        return back()->with('success', 'Navigation menu updated.');
    }
    
    public function deleteMenu(NavigationMenu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu item removed.');
    }
}
