<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

class BusTicket extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => ProductStatus::class,
        'is_active' => 'boolean',
        'gallery' => 'array',
    ];
}
