<?php

namespace App\Services\OrderCouponDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OrderCouponDetail
 * @package App\Services\OrderCouponDetails
 * @author Richard Guevara
 */

class OrderCouponDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'order_payment_details';

    protected static $logAttributes = ['first_name', 'last_name', 'transaction_id', 'gateway', 'total_amount'];

    protected static $logName = 'order_payment_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Payment Detail has been {$eventName}";
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
        'transaction_id',
        'gateway',
        'total_amount',
    ];
}
