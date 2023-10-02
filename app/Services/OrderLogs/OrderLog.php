<?php

namespace App\Services\OrderLogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderLog
 * @package App\Services\OrderLogs
 * @author Guevara Web Graphics Studio
 */

class OrderLog extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'order_status_id',
        'user_id',
        'comments',
    ];
}
