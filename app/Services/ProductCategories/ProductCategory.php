<?php

namespace App\Services\ProductCategories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Contact
 * @package App\Services\ProductCategories
 * @author Guevara Web Graphics Studio
 */

class ProductCategory extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'product_category';

    protected static $logAttributes = ['title'];

    protected static $logName = 'product_category';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Product Category has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
