<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningRoomComment extends Model
{
    protected $fillable = ['planning_room_id', 'user_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
