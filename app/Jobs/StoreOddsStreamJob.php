<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\GameOdds\GameOdds;
use Illuminate\Support\Facades\File;
use App\Events\NewOddsReceived;

class StoreOddsStreamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OddsJamAPITrait;

    protected $jsonData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * Execute the job.
     * 
     * @return void
     *  
    */
    public function handle()
    {
        // $filePath = public_path('odds.json');

        $raw_query = json_decode($this->jsonData);

        // Merge entry_id and type into each bet item
        foreach ($raw_query->data as $bet) {

            $bet->entry_id = $raw_query->entry_id;
            $bet->type = $raw_query->type;

            $gameodds = GameOdds::where('uid', $bet->id)->whereNull('deleted_at')->first();

            if (!empty($gameodds)) {
                
                GameOdds::where('uid', $bet->id)->update([
                    'bet_name'  =>  $bet->bet_name, 
                    'bet_points'=>  $bet->bet_points, 
                    'bet_price' =>  $bet->bet_price,  
                    'bet_type'  =>  $bet->bet_type, 
                    'game_id'   =>  $bet->game_id, 
                    'is_live'   =>  $bet->is_live, 
                    'is_main'   =>  $bet->is_main, 
                    'league'    =>  $bet->league, 
                    'player_id' =>  $bet->player_id, 
                    'selection' =>  $bet->selection, 
                    'selection_line'    =>  $bet->selection_line, 
                    'selection_points'  =>  $bet->selection_points, 
                    'sport' =>  $bet->sport, 
                    'sportsbook'    =>  $bet->sportsbook, 
                    'timestamp' =>  $bet->timestamp, 
                    'entry_id'  =>  $bet->entry_id, 
                    'type'  =>  $bet->type, 
                    'market'    =>   $bet->bet_type,
                ]);

                $updateGamesPerMarket = $this->createGamesPerMarket( $bet->game_id, $bet->bet_type );

            } else {

                $input = [
                    'bet_name'  =>  $bet->bet_name, 
                    'bet_points'    =>  $bet->bet_points, 
                    'bet_price' =>  $bet->bet_price, 
                    'bet_type'  =>  $bet->bet_type, 
                    'game_id'   =>  $bet->game_id, 
                    'uid'   =>  $bet->id, 
                    'is_live'   =>  $bet->is_live, 
                    'is_main'   =>  $bet->is_main, 
                    'league'    =>  $bet->league, 
                    'player_id' =>  $bet->player_id, 
                    'selection' =>  $bet->selection, 
                    'selection_line'    =>  $bet->selection_line, 
                    'selection_points'  =>  $bet->selection_points, 
                    'sport' =>  $bet->sport, 
                    'sportsbook'    =>  $bet->sportsbook, 
                    'timestamp' =>  $bet->timestamp, 
                    'entry_id'  =>  $bet->entry_id, 
                    'type'  =>  $bet->type, 
                    'market'    =>   $bet->bet_type
                ];
                
                $create_odds = GameOdds::create($input);

                $storeGamesPerMarket = $this->createGamesPerMarket( $bet->game_id, $bet->bet_type );

            }

            event(new NewOddsReceived($bet));

            \Log::info('BET: ' . json_encode($bet) );
        }
    }
}
