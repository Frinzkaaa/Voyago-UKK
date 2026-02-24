<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentBookingRepository implements BookingRepositoryInterface
{
    public function all(): Collection
    {
        return Booking::with(['user', 'partner'])->latest()->get();
    }

    public function find(int $id): ?Booking
    {
        return Booking::with(['user', 'partner', 'logs'])->find($id);
    }

    public function updateStatus(int $id, string $status): bool
    {
        return Booking::where('id', $id)->update(['status' => $status]);
    }

    public function getLatest(int $limit = 10): Collection
    {
        return Booking::with(['user', 'partner'])->latest()->limit($limit)->get();
    }
}
