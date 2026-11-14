<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_summary',
        'content',
        'desktop_image',
        'mobile_image',
        'is_visible',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Boot helper to generate slug automatically on save if not provided.
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Relationship: A blog post belongs to a blog category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Scope: Filter posts that are marked visible/published.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
