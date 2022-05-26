<?php

namespace App\Services\Newsletters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Contact
 * @package App\Services\Newsletters
 * @author Bryan James Dela Luya
 */

class Newsletter extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'newsletter';

    protected static $logAttributes = ['email'];

    protected static $logName = 'newsletter';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Newsletter Subscriber has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email'
    ];
}
