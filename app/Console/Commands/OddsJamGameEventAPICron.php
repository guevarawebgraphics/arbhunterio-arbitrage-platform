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
use App\Services\GamesPerMarkets\GamesPerMarket;
use DB;

use Schema;
use DateTime;
use DateTimeZone;

class OddsJamGameEventAPICron extends Command
{
    /**
     * 
     * The name and signature of the console command.
     * @var string 
     * 
     * 
    */

    protected $signature = 'oddsjam_game_event_api:cron';

    /**
     * The console command description.
     *
     * @var string
     * 
     */

    protected $description = 'This CRON pull up game events from OddsJam';

    /**
     * Execute the console command.
     *
     * @return int
     * 
    **/

    public function handle()
    {   
        $todayDate = Carbon::today()->toDateString();

        $game_query = Game::where('start_date', 'LIKE', $todayDate . '%')->select('uid','markets')->get();

        foreach ( $game_query ?? [] as $game_field ) {
            $markets = json_decode($game_field->markets);
            if ( $markets != "[]" ) {
                GameOdds::where('game_id', $game_field->uid)->whereIn( 'bet_type', $markets )->delete();
                GamesPerMarket::where('game_id', $game_field->uid)->whereIn( 'bet_type', $markets )->delete();
            }
        }

        Game::where('start_date', 'LIKE', $todayDate . '%')->delete();

        $dateTime = $this->timeInterval();

        if ( !empty( $dateTime ) ) {
            foreach ( $dateTime ?? [] as $date ) {
                $job = new SendRequestOddsJamJob($date);
                Queue::pushOn('sync_games', $job);
            }
        }
    }

    private function timeInterval() {
        $currentDate = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
        $currentDate->setTime(0, 0, 0); // Set time to start of the day (12 am / 00:00)

        $intervals = [];

        // 24 hours * 4 days = 96 hours
        for ($i = 0; $i < 96; $i++) {
            // Create a clone of the DateTime object for the start of the current hour
            $startOfHour = clone $currentDate;
            $startOfHour->modify("+$i hour");

            // Create a clone of the DateTime object for the end of the current hour
            $endOfHour = clone $startOfHour;
            $endOfHour->modify('+1 hour');

            // Append to intervals array
            $intervals[] = [
                'start_date_after'  => $startOfHour->format(DateTime::ATOM), // ISO 8601 format for the start of the hour
                'start_date_before' => $endOfHour->format(DateTime::ATOM), // ISO 8601 format for the end of the hour
            ];
        }

        return $intervals;
    }


}