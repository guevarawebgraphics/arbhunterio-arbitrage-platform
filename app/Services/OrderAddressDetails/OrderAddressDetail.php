<?php

namespace App\Services\OrderAddressDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OrderAddressDetail
 * @package App\Services\Products
 * @author Richard Guevara
 */

class OrderAddressDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'order_address_details';

    protected static $logAttributes = ['first_name', 'last_name', 'email', 'phone'];

    protected static $logName = 'order_address_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Address Detail has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
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
}
