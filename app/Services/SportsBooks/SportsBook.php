<?php

namespace App\Services\SportsBooks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SportsBook
 * @package App\Services\SportsBooks
 * @author Richard Guevara
 */

class SportsBook extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sportsbooks';

    protected static $logAttributes = ['name'];

    protected static $logName = 'sportsbooks';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "SportsBook has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_active'
    ];
}
