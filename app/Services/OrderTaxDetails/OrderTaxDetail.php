<?php

namespace App\Services\OrderTaxDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class OrderTaxDetail
 * @package App\Services\OrderTaxDetails
 * @author Guevara Web Graphics Studio
 */

class OrderTaxDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'order_tax_details';

    protected static $logAttributes = ['tax_percentage', 'total_amount'];

    protected static $logName = 'order_tax_details';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order Tax Detail has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'tax_percentage',
        'total_amount',
    ];
}
