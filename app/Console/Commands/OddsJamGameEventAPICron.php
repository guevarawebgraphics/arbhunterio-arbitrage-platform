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
        echo "Successfully retrieved!";
    }

    public function performAction( $data ) {

       


    }

}