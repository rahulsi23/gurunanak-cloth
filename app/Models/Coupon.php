<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_percentage', 'is_active'];

    protected function casts(): array
    {
        return [
            'discount_percentage' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
