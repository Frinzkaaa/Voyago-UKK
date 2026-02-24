<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class EloquentProductRepository implements ProductRepositoryInterface
{
    protected $tableMap = [
        'kereta' => 'train_tickets',
        'pesawat' => 'flight_tickets',
        'bus' => 'bus_tickets',
        'hotel' => 'hotels',
        'wisata' => 'wisata_spots',
    ];

    public function getByCategory(string $category): Collection
    {
        $tableName = $this->tableMap[$category] ?? null;
        if (!$tableName)
            return collect();
        return DB::table($tableName)->get();
    }

    public function find(string $category, int $id)
    {
        $tableName = $this->tableMap[$category] ?? null;
        if (!$tableName)
            return null;
        return DB::table($tableName)->where('id', $id)->first();
    }

    public function updateStatus(string $category, int $id, string $status): bool
    {
        $tableName = $this->tableMap[$category] ?? null;
        if (!$tableName)
            return false;
        return DB::table($tableName)->where('id', $id)->update(['status' => $status]);
    }

    public function getPlatformStats(): array
    {
        $stats = [];
        foreach ($this->tableMap as $category => $table) {
            $stats[$category] = DB::table($table)->count();
        }
        return $stats;
    }
}
