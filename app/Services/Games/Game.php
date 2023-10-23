<?php

namespace App\Services\Games;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Game
 * @package App\Services\Games
 * @author Richard Guevara
 */

class Game extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'games';

    protected static $logAttributes = [ 'uid',
        'start_date',
        'home_team',
        'away_team',
        'is_live',
        'is_popular',
        'tournament',
        'status',
        'sport',
        'league',
        'home_team_info',
        'away_team_info',
        'markets'];

    protected static $logName = 'games';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Game has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'start_date',
        'home_team',
        'away_team',
        'is_live',
        'is_popular',
        'tournament',
        'status',
        'sport',
        'league',
        'home_team_info',
        'away_team_info',
        'markets',
        'is_active'
    ];
}
