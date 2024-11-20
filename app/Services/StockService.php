<?php

namespace App\Services;

use App\Models\Stock;
use App\Interfaces\Services\StockServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use DB;

class StockService implements StockServiceInterface
{
    private Client $client;
    private string $token;

    public function __construct(){
        $this->client = new Client(
          [
            'base_uri'=> 'https://brapi.dev/api/',
            'timeout' => 60,
            // 'headers' => [
            //     'Authorization' => $this->token
            // ]
          ]
            
        );

        $this->token = env('BRAPI_API_TOKEN', '');
    }
    public function getStocksFromApi(): array
    {

        $url = 'quote/list';

        try {
            $response = $this->client->requestAsync('GET', $url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                ],
            ]);

            $response = $response->wait(); // Aguarda a execução do request

            $data = json_decode($response->getBody(), true);
            
            if (isset($data['stocks']) && is_array($data['stocks'])) {

                $this->saveStocks($data['stocks']); // Salva no banco de dados
                return $data['stocks'];
            }

            return [];
        } catch (RequestException $e) {
            return [];
        }
    }

    private function saveStocks(array $stocks): void
    {
        foreach ($stocks as $stock) {
            DB::transaction(function () use ($stock) {
                Stock::updateOrCreate(
                    ['symbol' => $stock['stock']], 
                    [
                        'name' => $stock['name'],
                        'close' => $stock['close'],
                        'change' => $stock['change'],
                        'volume' => $stock['volume'],
                        'market_cap' => $stock['market_cap'],
                        'sector' => $stock['sector'],
                        'type' => $stock['type'],
                        'logo_url' => $stock['logo'], 
                    ]
                );
            });
        }
    }
}
