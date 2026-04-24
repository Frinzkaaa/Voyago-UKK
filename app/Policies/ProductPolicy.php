<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class ProductPolicy
{
    use HandlesAuthorization;

    private function isOwnedBy(User $user, $product): bool
    {
        $ownerId = $product->user_id ?? $product->mitra_id ?? null;

        if ($ownerId === null) {
            return false;
        }

        return (int) $user->id === (int) $ownerId;
    }

    /**
     * Admin can view all products.
     * Partner can only view their own.
     */
    public function view(User $user, $product): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        return $this->isOwnedBy($user, $product);
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

        return $user->role === UserRole::PARTNER && $this->isOwnedBy($user, $product);
    }

    /**
     * Only Admin can approve products.
     */
    public function approve(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
