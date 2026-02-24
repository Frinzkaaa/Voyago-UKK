<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningRoomItem extends Model
{
    protected $fillable = [
        'planning_room_id',
        'category',
        'product_id',
        'title',
        'subtitle',
        'price',
        'image',
        'date_info',
        'optional_stats'
    ];

    public function votes()
    {
        return $this->hasMany(PlanningRoomVote::class);
    }

    public function getVotesUpAttribute()
    {
        return $this->votes()->where('type', 'up')->count();
    }

    public function getVotesDownAttribute()
    {
        return $this->votes()->where('type', 'down')->count();
    }

    public function room()
    {
        return $this->belongsTo(PlanningRoom::class, 'planning_room_id');
    }
}
