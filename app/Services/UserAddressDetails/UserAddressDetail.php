<?php

namespace App\Services\UserAddressDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Menus\Menu;
use App\Services\Pages\Page;

/**
 * Class Contact
 * @package App\Services\UserAddressDetails
 * @author Richard Guevara
 */

class UserAddressDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'user_address_details';

    protected static $logAttributes = ['first_name', 'last_name', 'email', 'phone'];

    protected static $logName = 'user_address_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User Address has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'ext',
        'company',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'country',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo('App\Services\Users\User', 'user_id');
    }
}
