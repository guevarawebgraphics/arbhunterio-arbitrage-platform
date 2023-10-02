<?php

namespace App\Services\BlogCategories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class BlogCategory
 * @package App\Services\BlogCategories
 * @author Guevara Web Graphics Studio
 */

class BlogCategory extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'blog_categories';

    protected static $logAttributes = ['name', 'description'];

    protected static $logName = 'blog_categories';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Blog Category has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
