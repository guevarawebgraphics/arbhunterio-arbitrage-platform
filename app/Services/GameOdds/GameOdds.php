<?php

namespace App\Services\GameOdds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class GameOdds
 * @package App\Services\GameOdds
 * @author Richard Guevara
 */

class GameOdds extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'gameodds';

    protected static $logAttributes = [ 
        'bet_name',
        'bet_points',
        'bet_price',
        'bet_type',
        'game_id',
        'uid',
        'is_live',
        'is_main',
        'league',
        'player_id',
        'selection',
        'selection_line',
        'selection_points',
        'sport',
        'sportsbook',
        'timestamp',
        'entry_id',
        'type',
        'is_active'
    ];

    protected static $logName = 'gameodds';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "GameOdds has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bet_name',
        'bet_points',
        'bet_price',
        'bet_type',
        'game_id',
        'uid',
        'is_live',
        'is_main',
        'league',
        'player_id',
        'selection',
        'selection_line',
        'selection_points',
        'sport',
        'sportsbook',
        'timestamp',
        'entry_id',
        'type',
        'market',
        'team_type',
        'is_active'
    ];

    public function games() {
        return $this->belongsTo('App\Services\Games\Game', 'uid', 'game_id');
    }
}
