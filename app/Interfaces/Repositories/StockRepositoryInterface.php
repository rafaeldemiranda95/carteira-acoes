<?php

namespace App\Interfaces\Repositories;

use App\Models\Stock;

interface StockRepositoryInterface
{
    public function findBySymbol(string $symbol): ?Stock;
    public function createOrUpdate(array $data): Stock;
    public function getAll(): array;
}
