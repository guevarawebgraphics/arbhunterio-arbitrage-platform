<?php

namespace App\Services\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Contact
 * @package App\Services\Contacts
 * @author Guevara Web Graphics Studio
 */

class Contact extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'contacts';

    protected static $logAttributes = ['name', 'email', 'subject', 'message'];

    protected static $logName = 'contacts';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Contact has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message'
    ];
}
