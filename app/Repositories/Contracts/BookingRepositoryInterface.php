<?php

namespace App\Repositories\Contracts;

use App\Models\Booking;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Booking;
    public function updateStatus(int $id, string $status): bool;
    public function getLatest(int $limit = 10): Collection;
}
