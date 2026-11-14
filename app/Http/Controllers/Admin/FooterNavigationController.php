<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class FooterNavigationController extends Controller
{
    public function index()
    {
        $menus = NavigationMenu::where('menu_type', 'footer')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();
            
        $products = \App\Models\Product::orderBy('title')->get();
        
        return view('admin.navigation.footer', compact('menus', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string',
            'parent_id' => 'nullable|exists:navigation_menus,id',
        ]);

        $lastOrder = NavigationMenu::where('menu_type', 'footer')
            ->where('parent_id', $request->parent_id)
            ->max('sort_order') ?? 0;

        NavigationMenu::create([
            'label' => $request->label,
            'url' => $request->url,
            'parent_id' => $request->parent_id,
            'sort_order' => $lastOrder + 1,
            'is_active' => true,
            'menu_type' => 'footer',
        ]);

        return back()->with('success', 'Footer menu item created successfully!');
    }

    public function update(NavigationMenu $menu, Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string',
        ]);

        $menu->update([
            'label' => $request->label,
            'url' => $request->url,
        ]);

        return back()->with('success', 'Footer menu item updated successfully!');
    }

    public function destroy(NavigationMenu $menu)
    {
        // Delete all children first to prevent orphaned records
        $menu->children()->delete();
        $menu->delete();

        return back()->with('success', 'Footer menu item and all its submenus removed successfully!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'menu_order' => 'required|array',
            'menu_order.*.id' => 'required|exists:navigation_menus,id',
            'menu_order.*.children' => 'nullable|array',
        ]);

        $menuOrder = $request->input('menu_order');

        foreach ($menuOrder as $index => $parentData) {
            NavigationMenu::where('id', $parentData['id'])->update([
                'parent_id' => null,
                'sort_order' => $index + 1
            ]);

            if (isset($parentData['children']) && is_array($parentData['children'])) {
                foreach ($parentData['children'] as $childIndex => $childData) {
                    NavigationMenu::where('id', $childData['id'])->update([
                        'parent_id' => $parentData['id'],
                        'sort_order' => $childIndex + 1
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
