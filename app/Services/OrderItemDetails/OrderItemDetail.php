<?php

namespace App\Services\OrderItemDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OrderItemDetail
 * @package App\Services\OrderItemDetails
 * @author Richard Guevara
 */

class OrderItemDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'order_item_details';

    protected static $logAttributes = ['name', 'product_unit', 'quantity', 'price'];

    protected static $logName = 'order_item_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Item Detail has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'name',
        'product_unit',
        'quantity',
        'price',
    ];
}
