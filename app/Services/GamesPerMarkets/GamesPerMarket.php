<?php

namespace App\Services\GamesPerMarkets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class GamesPerMarket
 * @package App\Services\GamesPerMarkets
 * @author Richard Guevara
 */

class GamesPerMarket extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'gamespermarkets';

    protected static $logAttributes = ['name'];

    protected static $logName = 'gamespermarkets';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "GamesPerMarket has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'bet_type',
        'best_odds_a',
        'best_odds_b',
        'selection_line_a',
        'selection_line_b',
        'profit_percentage',
        'sportsbook_a',
        'sportsbook_b',
        'is_below_one',
        'is_active'
    ];
}
