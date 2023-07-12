<?php

namespace Database\Seeders;

use App\Helpers\CryptoAPI\CoinGeckoApi;
use App\Models\Crypto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api = new CoinGeckoApi();
        $results = $api->getCoinsMarkets();

        foreach($results as $result){
            $data = Crypto::updateOrCreate(
                ['identifier' => $result['identifier']],
                [
                    'symbol' => $result['symbol'],
                    'name' => $result['name'],
                    'rank' => $result['rank'],
                    'date_added' => Crypto::where('identifier', $result['identifier'])->value('date_added') ?? now()
                ]
            );
        }
    }
}
