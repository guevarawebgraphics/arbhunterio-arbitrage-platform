<?php

namespace App\Services\SaveFilters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SaveFilter
 * @package App\Services\SaveFilters
 * @author Richard Guevara
 */

class SaveFilter extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'savefilters';

    protected static $logAttributes = ['name'];

    protected static $logName = 'savefilters';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "SaveFilter has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'min_profit',
        'max_profit',
        'sportsbook',
        'sports',
        'markets',
        'datetime',
        'is_alert',
        'is_active'
    ];
}
