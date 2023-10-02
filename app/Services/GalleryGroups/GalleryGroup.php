<?php

namespace App\Services\GalleryGroups;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class GalleryGroup
 * @package App\Services\GalleryGroups
 * @author Guevara Web Graphics Studio
 */

class GalleryGroup extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'gallery_group';

    protected static $logAttributes = ['name', 'description'];

    protected static $logName = 'gallery_groups';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Gallery Group has been {$eventName}";
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
