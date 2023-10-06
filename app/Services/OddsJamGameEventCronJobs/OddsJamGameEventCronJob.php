<?php

namespace App\Services\OddsJamGameEventCronJobs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OddsJamGameEventCronJob
 * @package App\Services\OddsJamGameEventCronJobs
 * @author Richard Guevara
 */

class OddsJamGameEventCronJob extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'oddsjamgameeventcronjobs';

    protected static $logAttributes = ['name'];

    protected static $logName = 'oddsjamgameeventcronjobs';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "OddsJamGameEventCronJob has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'game_event_json',
        'is_active'
    ];
}
