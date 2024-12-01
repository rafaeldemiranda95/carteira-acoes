<?php

namespace App\Services;

use App\Models\Stock;
use App\Interfaces\Services\StockServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use DB;
use App\Models\Dividend;
use Spatie\Async\Pool;
use Throwable;


class StockService implements StockServiceInterface
{
    private Client $clientBrapi;
    private Client $clientApiDividends;
    private string $token;

    public function __construct(){
        $this->clientBrapi = new Client(
          [
            'base_uri'=> 'https://brapi.dev/api/',
            'timeout' => 60,
          ]
            
        );

        $this->clientApiDividends = new Client(
            [
              'base_uri'=> 'https://king-prawn-app-r2dal.ondigitalocean.app/stock/',
              'timeout' => 60,
            ]
              
          );

        $this->token = env('BRAPI_API_TOKEN', '');
    }
 

    public function getStocksFromApi(): array
    {
        set_time_limit(0); 
        
        $url = 'quote/list';

        try {
            $response = $this->clientBrapi->requestAsync('GET', $url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                ],
            ]);

            $response = $response->wait(); 

            $data = json_decode($response->getBody(), true);

            if (isset($data['stocks']) && is_array($data['stocks'])) {
                $this->saveStocks($data['stocks']);

                // Inicializando o Pool para rodar as tarefas em paralelo
                $pool = Pool::create();

                foreach ($data['stocks'] as $stock) {
                    echo "Processando ação: {$stock['stock']}\n";
                    $pool->add(function () use ($stock) {
                        // Executa a lógica em paralelo para cada ação
                        $this->getStockInformations($stock['stock']);
                    })->catch(function (Throwable $exception) {
                        // Trate exceções para evitar que o pool falhe por completo
                        echo "Erro ao processar ação: {$exception->getMessage()}\n";
                    });
                }

                // Aguarda todas as tarefas terminarem
                $pool->wait();

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
    
    public function getStockInformations(string $symbol): array
    {
        try {
            $data = $this->fetchStockData($symbol);
            return $data;
        } catch (RequestException $e) {
            return [];
        }
    }

    private function fetchStockData(string $symbol): array
    {
        $response = $this->clientApiDividends->requestAsync('GET', "{$symbol}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}",
            ],
        ])->wait();

        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody);
        $dividendsArray = json_decode(json_encode($responseData->historical_dividends), true);
        $this->saveDividends($dividendsArray, $symbol);

        return json_decode($response->getBody(), true);
    }

    private function saveDividends(array $dividends, string $symbol): void{
        $id = $this->findStockIdBySymbol($symbol);
        foreach($dividends as $key => $dividend){
            $formattedDate = (new \DateTime($key))->format('Y-m-d');
            DB::transaction(function () use ($dividend, $id,   $formattedDate) {
                Dividend::updateOrCreate(
                    ['stock_id' => $id, 'date' => $formattedDate], 
                    [
                        'value' => $dividend,
                    ]
                );
            });
        }
    }

    private function findStockIdBySymbol(string $symbol): ?int{
        $stock = Stock::where('symbol', $symbol)->first();
        return $stock ? $stock->id : null;
    }
}
