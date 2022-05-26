<?php

namespace App\Services\Countries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Country
 * @package App\Services\Countries
 * @author Richard Guevara
 */

class Country extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'countries';

    protected static $logAttributes = ['code', 'name'];

    protected static $logName = 'countries';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Country has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'is_default',
    ];
}
