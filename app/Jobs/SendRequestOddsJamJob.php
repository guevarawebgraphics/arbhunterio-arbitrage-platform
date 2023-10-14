<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\OddsJamAPITrait;

class SendRequestOddsJamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OddsJamAPITrait;

    protected $arrayDates;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arrayDates)
    {
        $this->arrayDates = $arrayDates;
    }

    /**
     * Execute the job.
     * 
     * @return void
     *  
    */
    public function handle()
    {

        $headers = ["Content-Type: application/json"];
        $baseURL = url('api/game-listingv2');
        $data = $this->arrayDates;

        $queryParams = [
            'key' => config('services.oddsjam.key')
        ];

        $queryParams['start_date_before'] =  $data['start_date_before'];
        $queryParams['start_date_after'] =  $data['start_date_after'];

        $url = $baseURL . '?' . http_build_query($queryParams);

        $response = $this->makeAPIRequest($url, $headers);

        \Log::info('Oddsjam Response: ' . json_encode($response) ); 
        
    }
}
