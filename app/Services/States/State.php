<?php

namespace App\Services\States;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Countries\Country;

/**
 * Class State
 * @package App\Services\States
 * @author Richard Guevara
 */

class State extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'states';

    protected static $logAttributes = ['code', 'name', 'state_id'];

    protected static $logName = 'states';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "State has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'state_id',
        'is_default',
    ];

    public final function country()
    {
        return $this->belongsTo(Country::class);
    }
}
