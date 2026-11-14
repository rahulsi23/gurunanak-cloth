<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'meta_title',
        'slug',
        'subtitle',
        'price',
        'image_path',
        'lookbook',
        'category_slug',
        'sizes',
        'description',
        'short_description',
        'meta_description',
        'is_featured',
        'is_visible',
        'sort_order',
        'color',
        'size',
        'mesh_ids',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_visible' => 'boolean',
        'mesh_ids' => 'array',
    ];

    protected $appends = [
        'image_url',
        'primary_image',
        'image',
    ];

    /**
     * Get dynamic primary image URL.
     */
    public function getImageUrlAttribute(): string
    {
        $img = $this->image_path;
        if (empty($img)) {
            if ($this->relationLoaded('images')) {
                $img = $this->images->first()?->image_path;
            } else {
                $img = $this->images()->orderBy('sort_order')->value('image_path');
            }
        }
        if (empty($img)) {
            return 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80';
        }
        return str_starts_with($img, 'http') ? $img : url($img);
    }

    public function getPrimaryImageAttribute(): string
    {
        return $this->image_url;
    }

    public function getImageAttribute(): string
    {
        return $this->image_url;
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    /**
     * Get all active sibling products in the mesh variation family.
     */
    public function getMeshFamily()
    {
        if (empty($this->mesh_ids) || !is_array($this->mesh_ids)) {
            return collect([$this]);
        }
        return self::whereIn('id', $this->mesh_ids)
            ->where('is_visible', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Get or create a product dynamically based on slug.
     */
    public static function getOrCreateId($slug, $title, $lookbook, $category, $price, $image)
    {
        $product = self::where('slug', $slug)->first();
        if (!$product) {
            $product = self::create([
                'title' => $title,
                'slug' => $slug,
                'lookbook' => $lookbook,
                'category_slug' => $category,
                'price' => $price,
                'image_path' => $image,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'description' => 'Premium tailored structure offering effortless elegance.',
                'is_visible' => true,
            ]);
        }
        return $product->id;
    }
}
