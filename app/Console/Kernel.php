<?php

namespace App\Console;

use App\Helpers\CryptoAPI\CoinGeckoApi;
use App\Models\Crypto;
use App\Models\CryptoHistory;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $api = new CoinGeckoApi();
            $coins_from_db = Crypto::all();
            $identifiers = [];
            foreach ($coins_from_db as $coin_from_db) {
                $identifiers[] = $coin_from_db['identifier'];
            }
            $coins_from_gecko = $api->getCoinsMarkets('usd', $identifiers);

            foreach ($coins_from_gecko as $coin_from_gecko) {
                $crypto = Crypto::where('identifier', $coin_from_gecko['identifier'])->first();
                $data = CryptoHistory::create([
                    'crypto_id' => $crypto->id,
                    'interval' => 'm10',
                    'current_price' => $coin_from_gecko['current_price'],
                    'date' => Carbon::parse($coin_from_gecko['date'])->format('Y-m-d H:i:s')
                ]);
            }
        })->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
