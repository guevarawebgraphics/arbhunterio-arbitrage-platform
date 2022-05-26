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

    protected $table = 'order_coupon_details';

    protected static $logAttributes = ['coupon_id', 'coupon_code', 'total_amount'];

    protected static $logName = 'order_coupon_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Coupon Detail has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'coupon_id',
        'coupon_code',
        'total_amount',
    ];
}
