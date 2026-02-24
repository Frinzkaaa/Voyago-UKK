<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

class WisataSpot extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => ProductStatus::class,
        'is_active' => 'boolean',
        'gallery' => 'array',
        'spot_images' => 'array',
        'package_images' => 'array',
    ];
}
