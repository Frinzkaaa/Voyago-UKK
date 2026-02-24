<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningRoomVote extends Model
{
    protected $fillable = ['planning_room_item_id', 'user_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
