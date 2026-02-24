<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningRoomMember extends Model
{
    protected $fillable = ['planning_room_id', 'user_id', 'role'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
