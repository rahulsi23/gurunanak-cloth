<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'parent_id',
        'sort_order',
        'is_active',
        'menu_type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(NavigationMenu::class, 'parent_id');
    }
}
