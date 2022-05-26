<?php

namespace App\Services\OrderStatus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderStatus
 * @package App\Services\OrderStatus
 * @author Bryan James Dela Luya
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
