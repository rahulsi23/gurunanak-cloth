<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of catalog products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('lookbook') && $request->lookbook !== '') {
            $query->where('lookbook', $request->lookbook);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('lookbook', 'like', "%{$search}%")
                  ->orWhere('category_slug', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('size', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->paginate(20);
        $lookbooks = ['women', 'men', 'oversized', 'accessories', 'streetwear', 'summer'];

        return view('admin.products.index', compact('products', 'lookbooks'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $lookbooks = [
            'women' => 'Womenswear Atelier',
            'men' => 'Menswear Atelier',
            'oversized' => 'Oversized Volumes',
            'accessories' => 'Bespoke Accessories',
            'streetwear' => 'Streetwear Lab',
            'summer' => 'Summer Resort',
        ];

        $categories = Category::all();
        $allProducts = Product::orderBy('title')->get();

        return view('admin.products.create', compact('lookbooks', 'categories', 'allProducts'));
    }

    /**
     * Store a newly created product in storage with auto-WebP conversion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'subtitle' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'lookbook' => 'required|string',
            'category_slug' => 'required|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'product_images' => 'required_without:image|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_visible' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'mesh_product_ids' => 'nullable|array',
            'mesh_product_ids.*' => 'integer|exists:products,id',
            'primary_image_index' => 'nullable|integer',
        ]);

        $data = $request->except(['image', 'product_images', 'sizes', 'mesh_product_ids', 'primary_image_index']);
        
        // Auto-generate slug if empty
        $data['slug'] = empty($validated['slug']) ? Str::slug($validated['title']) : Str::slug($validated['slug']);
        
        // Ensure slug uniqueness fallback
        if (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'] . '-' . uniqid();
        }

        // Process sizes string to array perfectly
        if (!empty($validated['sizes'])) {
            $data['sizes'] = array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))));
        } else {
            $data['sizes'] = ['OS'];
        }

        $data['is_visible'] = $request->has('is_visible') ? true : false;
        $data['sort_order'] = $request->input('sort_order', 999);

        // Process all uploads
        $filesToUpload = [];
        if ($request->hasFile('product_images')) {
            $filesToUpload = $request->file('product_images');
        } elseif ($request->hasFile('image')) {
            $filesToUpload = [$request->file('image')];
        }

        $uploadedPaths = [];
        foreach ($filesToUpload as $file) {
            $uploadedPaths[] = $this->uploadAndConvertWebp($file);
        }

        $primaryIndex = intval($request->input('primary_image_index', 0));
        if (!isset($uploadedPaths[$primaryIndex]) && !empty($uploadedPaths)) {
            $primaryIndex = 0;
        }

        if (!empty($uploadedPaths)) {
            $data['image_path'] = $uploadedPaths[$primaryIndex];
        } else {
            $data['image_path'] = '';
        }

        $product = Product::create($data);

        // Save all images to product_images gallery
        foreach ($uploadedPaths as $idx => $path) {
            $product->images()->create([
                'image_path' => $path,
                'sort_order' => $idx,
            ]);
        }

        // Process Variations
        if ($request->has('variations') && is_array($request->variations)) {
            foreach ($request->variations as $var) {
                if (!empty($var['size']) || !empty($var['color'])) {
                    $product->variations()->create([
                        'size_label' => $var['size'] ?? null,
                        'color_label' => $var['color'] ?? null,
                        'stock_quantity' => intval($var['stock'] ?? 0),
                        'sku_code' => $var['sku'] ?? null,
                    ]);
                }
            }
        }

        // Process Mesh Relations
        $meshProductIds = $request->input('mesh_product_ids', []);
        if (!empty($meshProductIds)) {
            $newMeshFamily = array_unique(array_merge($meshProductIds, [$product->id]));
            sort($newMeshFamily);

            foreach ($newMeshFamily as $famId) {
                $famMember = Product::find($famId);
                if ($famMember) {
                    $famMember->mesh_ids = $newMeshFamily;
                    $famMember->save();
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Premium piece successfully cataloged and mapped to standard WebP format.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Self-healing legacy product images
        if ($product->images()->count() === 0 && !empty($product->image_path)) {
            $product->images()->create([
                'image_path' => $product->image_path,
                'sort_order' => 0,
            ]);
            $product->refresh();
        }

        $lookbooks = [
            'women' => 'Womenswear Atelier',
            'men' => 'Menswear Atelier',
            'oversized' => 'Oversized Volumes',
            'accessories' => 'Bespoke Accessories',
            'streetwear' => 'Streetwear Lab',
            'summer' => 'Summer Resort',
        ];

        $categories = Category::all();
        $sizesString = is_array($product->sizes) ? implode(', ', $product->sizes) : '';
        $allProducts = Product::where('id', '!=', $product->id)->orderBy('title')->get();

        return view('admin.products.edit', compact('product', 'lookbooks', 'categories', 'sizesString', 'allProducts'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'subtitle' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'lookbook' => 'required|string',
            'category_slug' => 'required|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_visible' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'mesh_product_ids' => 'nullable|array',
            'mesh_product_ids.*' => 'integer|exists:products,id',
            'deleted_image_ids' => 'nullable|array',
            'deleted_image_ids.*' => 'integer',
            'primary_image_source' => 'nullable|string',
            'primary_image_id' => 'nullable|integer',
            'primary_image_index' => 'nullable|integer',
        ]);

        $data = $request->except(['image', 'product_images', 'sizes', 'mesh_product_ids', 'deleted_image_ids', 'primary_image_source', 'primary_image_id', 'primary_image_index']);
        
        $data['slug'] = empty($validated['slug']) ? Str::slug($validated['title']) : Str::slug($validated['slug']);

        if (!empty($validated['sizes'])) {
            $data['sizes'] = array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))));
        } else {
            $data['sizes'] = ['OS'];
        }

        $data['is_visible'] = $request->has('is_visible') ? true : false;
        $data['sort_order'] = $request->input('sort_order', 999);

        // 1. Process Image Deletions
        $deletedImageIds = $request->input('deleted_image_ids', []);
        if (!empty($deletedImageIds)) {
            $imagesToDelete = $product->images()->whereIn('id', $deletedImageIds)->get();
            foreach ($imagesToDelete as $img) {
                if (!empty($img->image_path)) {
                    $oldRelative = str_replace(asset('/'), '', $img->image_path);
                    $oldFull = public_path($oldRelative);
                    if (file_exists($oldFull) && is_file($oldFull)) {
                        @unlink($oldFull);
                    }
                }
                $img->delete();
            }
        }

        // 2. Handle Old Legacy Image Upload (Fallback)
        if ($request->hasFile('image')) {
            $newPrimaryPath = $this->uploadAndConvertWebp($request->file('image'));
            $newGalleryItem = $product->images()->create([
                'image_path' => $newPrimaryPath,
                'sort_order' => 0,
            ]);
            $data['image_path'] = $newPrimaryPath;
        }

        // 3. Process New Gallery Images Uploads
        $newUploadedPaths = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $file) {
                $path = $this->uploadAndConvertWebp($file);
                $newGalleryItem = $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => 999,
                ]);
                $newUploadedPaths[] = [
                    'id' => $newGalleryItem->id,
                    'path' => $path
                ];
            }
        }

        // 4. Resolve Starred Primary Image Path
        $primaryImagePath = null;
        $primarySource = $request->input('primary_image_source');
        
        if ($primarySource === 'existing') {
            $existingId = $request->input('primary_image_id');
            $existingImg = $product->images()->find($existingId);
            if ($existingImg) {
                $primaryImagePath = $existingImg->image_path;
            }
        } elseif ($primarySource === 'new') {
            $newIndex = intval($request->input('primary_image_index', 0));
            if (isset($newUploadedPaths[$newIndex])) {
                $primaryImagePath = $newUploadedPaths[$newIndex]['path'];
            }
        }

        // Fallback: If no primary image path was set or resolved, pick the first image in the gallery
        if (empty($primaryImagePath)) {
            $firstImg = $product->images()->orderBy('sort_order')->orderBy('id')->first();
            if ($firstImg) {
                $primaryImagePath = $firstImg->image_path;
            }
        }

        if (!empty($primaryImagePath)) {
            $data['image_path'] = $primaryImagePath;
        }

        $product->update($data);

        // Process Variations
        if ($request->has('variations') && is_array($request->variations)) {
            $product->variations()->delete();
            
            foreach ($request->variations as $var) {
                if (!empty($var['size']) || !empty($var['color'])) {
                    $product->variations()->create([
                        'size_label' => $var['size'] ?? null,
                        'color_label' => $var['color'] ?? null,
                        'stock_quantity' => intval($var['stock'] ?? 0),
                        'sku_code' => $var['sku'] ?? null,
                    ]);
                }
            }
        }

        // Process Mesh Relations (Absolute Overwrite & Sibling Sync Logic)
        $oldMeshIds = $product->mesh_ids ?? [];
        foreach ($oldMeshIds as $oldId) {
            if ($oldId != $product->id) {
                $sibling = Product::find($oldId);
                if ($sibling && is_array($sibling->mesh_ids)) {
                    $newSiblingMesh = array_values(array_diff($sibling->mesh_ids, [$product->id]));
                    $sibling->mesh_ids = empty($newSiblingMesh) || count($newSiblingMesh) <= 1 ? null : $newSiblingMesh;
                    $sibling->save();
                }
            }
        }

        $meshProductIds = $request->input('mesh_product_ids', []);
        if (!empty($meshProductIds)) {
            $newMeshFamily = array_unique(array_merge($meshProductIds, [$product->id]));
            sort($newMeshFamily);

            foreach ($newMeshFamily as $famId) {
                $famMember = Product::find($famId);
                if ($famMember) {
                    $famMember->mesh_ids = $newMeshFamily;
                    $famMember->save();
                }
            }
        } else {
            $product->mesh_ids = null;
            $product->save();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product specifications successfully synchronized with the database.');
    }

    /**
     * Remove the specified product from storage and clean disk space.
     */
    public function destroy(Product $product)
    {
        // Remove from mesh relations first
        $oldMeshIds = $product->mesh_ids ?? [];
        foreach ($oldMeshIds as $oldId) {
            if ($oldId != $product->id) {
                $sibling = Product::find($oldId);
                if ($sibling && is_array($sibling->mesh_ids)) {
                    $newSiblingMesh = array_values(array_diff($sibling->mesh_ids, [$product->id]));
                    $sibling->mesh_ids = empty($newSiblingMesh) || count($newSiblingMesh) <= 1 ? null : $newSiblingMesh;
                    $sibling->save();
                }
            }
        }

        // Image Gallery Garbage Collector: Delete all physical files from disk
        foreach ($product->images as $img) {
            if (!empty($img->image_path)) {
                $relativePath = str_replace(asset('/'), '', $img->image_path);
                $fullPath = public_path($relativePath);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $img->delete();
        }

        // Image Garbage Collector for legacy fallback
        if (!empty($product->image_path)) {
            $relativePath = str_replace(asset('/'), '', $product->image_path);
            $fullPath = public_path($relativePath);
            
            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Catalog piece successfully withdrawn and disk space optimized.');
    }

    public function toggleVisibility(Product $product)
    {
        $product->is_visible = !$product->is_visible;
        $product->save();

        return response()->json([
            'success' => true,
            'is_visible' => $product->is_visible,
        ]);
    }

    public function updateSortOrder(Request $request, Product $product)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $product->sort_order = $request->input('sort_order');
        $product->save();

        return response()->json([
            'success' => true,
            'sort_order' => $product->sort_order,
        ]);
    }

    /**
     * Upload and convert image file to standard WebP format.
     */
    private function uploadAndConvertWebp($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '-' . uniqid() . '.webp';
        $destinationPath = public_path('uploads/products');
        
        if (!file_exists($destinationPath)) {
            @mkdir($destinationPath, 0755, true);
        }
        
        if ($extension === 'webp') {
            $file->move($destinationPath, $filename);
        } else {
            $imagePath = $file->getRealPath();
            $image = null;
            
            if ($extension === 'jpg' || $extension === 'jpeg') {
                $image = @imagecreatefromjpeg($imagePath);
            } elseif ($extension === 'png') {
                $image = @imagecreatefrompng($imagePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            } elseif ($extension === 'gif') {
                $image = @imagecreatefromgif($imagePath);
            }
            
            if ($image) {
                @imagewebp($image, $destinationPath . '/' . $filename, 85);
                @imagedestroy($image);
            } else {
                $filename = time() . '-' . uniqid() . '.' . $extension;
                $file->move($destinationPath, $filename);
            }
        }
        
        return asset('uploads/products/' . $filename);
    }
}
