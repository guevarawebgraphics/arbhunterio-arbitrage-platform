<?php

namespace App\Services\OrderStatus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderStatus
 * @package App\Services\OrderStatus
 * @author Guevara Web Graphics Studio
 */

class OrderStatus extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
    ];
}
