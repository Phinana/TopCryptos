<?php

namespace App\Helpers\CryptoAPI;

use App\Helpers\CryptoAPI\Core\CryptoApiInterface;
use Illuminate\Support\Facades\Http;

class CoinGeckoApi implements CryptoApiInterface
{
    const URL = "https://api.coingecko.com/api/v3";

    protected function connect(string $url)
    {
        return Http::baseUrl(self::URL)
            ->withHeaders([
                "Accept" => "application/json",
                "version" => "20230302",
            ])
            ->get($url);
    }

    public function getCoinsMarkets(string $vs_currency = 'usd', array $ids = null, array $price_change_percentage = ['1h', '24h', '7d', '1y'])
    {
        $connect_url = "/coins/markets";
        if($vs_currency != null){ $params['vs_currency'] = $vs_currency; }

        $per_page = 5;
        if($ids != null){
             $params['ids'] = implode(',', $ids);
             $per_page = count($ids);
            }
        if($price_change_percentage != null){ $params['price_change_percentage'] = implode(',', $price_change_percentage); }

        $params['per_page'] = $per_page;

        if($params != "" || $params != null){
            $query_string = http_build_query($params);
            $connect_url = $connect_url . '?' . $query_string;
        }

        $coins = $this->connect($connect_url)->json();
        $coin_array = [];
        foreach($coins as $coin){
            $data = ([
                'identifier' => $coin['id'],
                'symbol' => $coin['symbol'],
                'name' => $coin['name'],
                'current_price' => $coin['current_price'],
                'rank' => $coin['market_cap_rank'],
                "date" => $coin['last_updated']
            ]);
            $coin_array[] = $data;
        }
        return $coin_array;
    }
}
