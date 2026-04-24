<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;

class BookingPolicy
{
    use HandlesAuthorization;

    private function matchesUserId($left, $right): bool
    {
        if ($left === null || $right === null) {
            return false;
        }

        return (int) $left === (int) $right;
    }

    /**
     * Admin can view all bookings.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * View a specific booking.
     * Admin: All
     * Partner: Only their products
     * User: Only their own bookings
     */
    public function view(User $user, Booking $booking): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role === UserRole::PARTNER) {
            return $this->matchesUserId($user->id, $booking->mitra_id);
        }

        return $this->matchesUserId($user->id, $booking->user_id);
    }

    /**
     * Only Admin can force cancel or override status.
     */
    public function forceCancel(User $user, Booking $booking): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Partner can confirm their own bookings.
     */
    public function confirm(User $user, Booking $booking): bool
    {
        return $user->role === UserRole::PARTNER && $this->matchesUserId($user->id, $booking->mitra_id);
    }
}
