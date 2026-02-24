<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function getByCategory(string $category): Collection;
    public function find(string $category, int $id);
    public function updateStatus(string $category, int $id, string $status): bool;
    public function getPlatformStats(): array;
}
