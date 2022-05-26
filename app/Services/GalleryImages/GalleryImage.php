<?php

namespace App\Services\GalleryImages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\GalleryGroups\GalleryGroup;

/**
 * Class GalleryImage
 * @package App\Services\GalleryImage
 * @author Richard Guevara
 */

class GalleryImage extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'image_gallery';

    protected static $logAttributes = ['title', 'content'];

    protected static $logName = 'image_gallery';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Gallery Image has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gallery_group_id',
        'title',
        'content',
        'background_image',
        'json_contents',
        'is_active'
    ];

    protected $with = [
        'group',
    ];

    public function group()
    {
        return $this->belongsTo(GalleryGroup::class, 'gallery_group_id');
    }
}
