<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'commission_rate',
        'rejection_reason',
        'service_type',
    ];

    protected $casts = [
        'status' => \App\Enums\PartnerStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
