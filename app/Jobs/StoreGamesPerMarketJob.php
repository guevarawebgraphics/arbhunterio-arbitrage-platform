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
use App\Services\GamesPerMarkets\GamesPerMarket;

class StoreGamesPerMarketJob implements ShouldQueue
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
    public function handle($data)
    {
        $game_id = $data['game_id'];

        $market = $data['market'];
        
        $game = GameOdds::query()
        ->withTrashed()
        ->from('gameodds as go')
        ->leftJoin('games as g', 'g.uid', '=', 'go.game_id')
        ->where('go.is_live', 0)
        ->where('g.uid', $game_id )
        ->where('go.bet_type', $market )
        ->select(
            'g.uid',
            'g.start_date',
            'g.home_team',
            'g.away_team',
            'go.bet_type',
            'g.sport',
            'g.league'
        )
        ->groupBy(
            'g.uid',
            'g.start_date',
            'g.home_team',
            'g.away_team',
            'go.bet_type',
            'g.sport',
            'g.league'
        )
        ->first();

        if ( !empty($game) ) {

            $odds_data = $this->getOdds($game);

            $games_per_market_stored = GamesPerMarket::create([
                'name'  =>  $game->home_team . ' vs ' . $game->away_team,
                'game_id'   =>  $game_id,
                'bet_type'  =>  $market,
                'best_odds_a'   =>  $odds_data['best_odds_a'],
                'best_odds_b'   =>  $odds_data['best_odds_b'],
                'selection_line_a'  =>  $odds_data['selection_line_a'],
                'selection_line_b'  =>  $odds_data['selection_line_b'],
                'profit_percentage' =>  $odds_data['profit_percentage'],
                'sportsbook_a'  =>  $odds_data['sportsbook_a'],
                'sportsbook_b'  =>  $odds_data['sportsbook_b']
            ]);

        }
    }
}
