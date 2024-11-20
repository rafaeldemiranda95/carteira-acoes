<?php

namespace App\Interfaces\Services;

interface StockServiceInterface
{
    public function getStocksFromApi(): array;
}
