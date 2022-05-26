<?php

namespace App\Services\OrderShippingDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OrderShippingDetail
 * @package App\Services\OrderShippingDetails
 * @author Bryan James Dela Luya
 */

class OrderShippingDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'order_shipping_details';

    protected static $logAttributes = ['shipping_method', 'reference_no', 'total_amount'];

    protected static $logName = 'order_shipping_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Shipping Detail has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'shipping_method',
        'reference_no',
        'total_amount',
    ];
}
