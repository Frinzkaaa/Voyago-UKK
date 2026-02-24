<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningRoom extends Model
{
    protected $fillable = ['user_id', 'title', 'destination', 'start_date', 'end_date', 'status'];

    public function members()
    {
        return $this->hasMany(PlanningRoomMember::class);
    }

    public function items()
    {
        return $this->hasMany(PlanningRoomItem::class);
    }

    public function comments()
    {
        return $this->hasMany(PlanningRoomComment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
