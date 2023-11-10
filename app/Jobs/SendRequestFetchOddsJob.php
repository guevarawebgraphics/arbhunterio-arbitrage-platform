<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\OddsJamAPITrait;

class SendRequestFetchOddsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OddsJamAPITrait;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     * 
     * @return void
     *  
    */
    public function handle()
    {
        $baseURL = url('api/fetch/odds');
        
        $game =  $this->data['game'];
        $sportsbook = $this->data['sportsbook'];

        
        $data = [
            'game' => $game,
            'sportsbook' => $sportsbook,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);


        
    }
}
