<?php

namespace App\Services\Carts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Product
 * @package App\Services\Carts
 * @author Richard Guevara
 */

class Cart extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_unit_id',
        'quantity',
        'price',
    ];
}
