<?php

namespace App\Services\Cities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class City
 * @package App\Services\Cities
 * @author Guevara Web Graphics Studio
 */

class City extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'cities';

    protected static $logAttributes = ['code', 'name', 'country_id', 'tax', 'is_default'];

    protected static $logName = 'cities';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "City has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'country_id',
        'tax',
        'is_default',
    ];
}
