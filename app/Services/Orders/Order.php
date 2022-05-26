<?php

namespace App\Services\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Order
 * @package App\Services\Orders
 * @author Bryan James Dela Luya
 */

class Order extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'orders';

    protected static $logAttributes = ['rference_no', 'subtotal_amount', 'total_amount', 'order_status_id', 'status'];

    protected static $logName = 'orders';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'reference_no',
        'subtotal_amount',
        'total_amount',
        'order_status_id',
        'notes',
    ];
}
