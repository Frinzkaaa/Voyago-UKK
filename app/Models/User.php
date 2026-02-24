<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Enums\UserRole;
use App\Enums\UserStatus;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'avatar',
        'password',
        'role',
        'status',
        'mitra_info',
        'points',
        'badge',
    ];

    public function updateBadge()
    {
        if ($this->points >= 500) {
            $this->badge = 'Platinum';
        } elseif ($this->points >= 200) {
            $this->badge = 'Gold';
        } elseif ($this->points >= 50) {
            $this->badge = 'Silver';
        } else {
            $this->badge = 'Bronze';
        }
        $this->save();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed', // Disabled hashing as per user request
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
}
