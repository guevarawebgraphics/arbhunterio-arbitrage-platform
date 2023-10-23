<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class OddsJamGameEventAPICron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oddsjam_game_event_api:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This CRON pull up game events from OddsJam';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $headers = ["Content-Type: application/json"];
        $baseURL = url('api/game-listing');
        $queryParams = [];

        $url = $baseURL . '?' . http_build_query($queryParams);
        
        $response = $this->makeAPIRequest($url, $headers);
        // \Log::info('Cron: ' . json_encode($response) );

        echo "Successfully retrieved!";
    }

    private function makeAPIRequest($url, $headers) {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $json = curl_exec($curl);

            if ($json === false) {
                throw new \Exception(curl_error($curl));
            }

            curl_close($curl);
            return json_decode($json, true);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return [
                'data' => NULL,
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }

}