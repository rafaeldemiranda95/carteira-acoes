<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Interfaces\Repositories\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    public function findBySymbol(string $symbol): ?Stock
    {
        return Stock::where('symbol', $symbol)->first();
    }

    public function createOrUpdate(array $data): Stock
    {
        return Stock::updateOrCreate(
            ['symbol' => $data['symbol']],
            $data
        );
    }

    public function getAll(): array
    {
        return Stock::all()->toArray();
    }
}
