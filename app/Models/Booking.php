<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'category',
        'item_id',
        'user_id',
        'mitra_id',
        'passenger_count',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'commission_amount',
        'net_income',
        'confirmed_at',
        'refund_reason',
    ];

    protected $casts = [
        'status' => \App\Enums\BookingStatus::class,
        'payment_status' => \App\Enums\PaymentStatus::class,
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function logs()
    {
        return $this->hasMany(BookingLog::class);
    }
}
