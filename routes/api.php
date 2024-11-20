<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/fetchStocks', function (Request $request) {

   $stockController = new StockController(
    new \App\Services\StockService(new \App\Repositories\StockRepository(new \App\Models\Stock())));
   return $stockController->fetchAndSaveStocks();
});
