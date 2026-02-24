<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'mitra_id',
        'subject',
        'category',
        'description',
        'status',
        'is_forwarded',
        'admin_response',
        'mitra_response'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
}
