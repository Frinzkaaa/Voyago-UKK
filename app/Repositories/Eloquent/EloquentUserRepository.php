<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByRole(string $role): Collection
    {
        return User::where('role', $role)->get();
    }

    public function updateStatus(int $userId, string $status): bool
    {
        return User::where('id', $userId)->update(['status' => $status]);
    }
}
