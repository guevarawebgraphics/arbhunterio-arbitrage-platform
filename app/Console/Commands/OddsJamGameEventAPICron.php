<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use App\Jobs\SendRequestOddsJamJob;
use Illuminate\Support\Facades\Queue;
use App\Services\Games\Game;
use App\Services\GameOdds\GameOdds;
use DB;

use Schema;
use DateTime;
use DateTimeZone;

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

        // Game::truncate();
        // Schema::disableForeignKeyConstraints();
        // Game::query()->delete();
        // Schema::enableForeignKeyConstraints();
                

        $dateTime = $this->timeInterval();
        if ( !empty( $dateTime ) ) {
            foreach ( $dateTime ?? [] as $date ) {
                $job = new SendRequestOddsJamJob($date);
                Queue::push($job);
            }
        }

    }

    private function timeInterval() {

        $currentDate = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
        // $currentDate = new DateTime('2023-10-22', new DateTimeZone(date_default_timezone_get()));

        $currentDate->setTime(0, 0, 0); // Set time to start of the day (12 am / 00:00)

        $intervals = [];

        for ($i = 0; $i < 48; $i++) {

            // Create a clone of the DateTime object for the start of the current hour
            $startOfHour = clone $currentDate;
            $startOfHour->modify("+$i hour");

            // Create a clone of the DateTime object for the end of the current hour
            $endOfHour = clone $startOfHour;
            $endOfHour->modify('+1 hour');

            // Append to intervals array
            $intervals[] = [
                'start_date_after'  => $startOfHour->format(DateTime::ATOM), // ISO 8601 format
                'start_date_before' => $endOfHour->format(DateTime::ATOM),
            ];

        }

        return $intervals;

    }

}