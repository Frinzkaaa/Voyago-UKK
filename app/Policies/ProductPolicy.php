<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Admin can view all products.
     * Partner can only view their own.
     */
    public function view(User $user, $product): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        return $user->id === ($product->user_id ?? $product->mitra_id);
    }

    /**
     * Partner can create products if verified.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::PARTNER && $user->status === UserStatus::ACTIVE;
    }

    /**
     * Only owner or admin can update.
     */
    public function update(User $user, $product): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        return $user->role === UserRole::PARTNER && $user->id === ($product->user_id ?? $product->mitra_id);
    }

    /**
     * Only Admin can approve products.
     */
    public function approve(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
