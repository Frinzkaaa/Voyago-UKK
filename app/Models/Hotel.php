<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

class Hotel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => ProductStatus::class,
        'is_active' => 'boolean',
        'gallery' => 'array',
        'room_images' => 'array',
        'facility_images' => 'array',
    ];
}
