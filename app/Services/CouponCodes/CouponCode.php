<?php

namespace App\Services\CouponCodes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class CouponCode
 * @package App\Services\CouponCodes
 * @author Bryan James Dela Luya
 */

class CouponCode extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'coupon_codes';

    protected static $logAttributes = ['name', 'code', 'value'];

    protected static $logName = 'coupon_codes';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Coupon Code has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'code',
        'value',
        'type',
        'times_of_use',
        'used',
        'once_per_customer',
        'apply_category',
        'apply_product',
        'is_no_time_limit',
        'date_start',
        'date_end',
    ];
}
