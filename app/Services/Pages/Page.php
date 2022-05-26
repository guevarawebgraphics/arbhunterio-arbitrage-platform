<?php

namespace App\Services\Pages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Sections\Section;
use App\Services\SeoMetas\SeoMeta;
use App\Http\Traits\Attachments\HasAttachment;

/**
 * Class Page
 * @package App\Services\Pages
 * @author Richard Guevara
 */

class Page extends Model
{
    use SoftDeletes, LogsActivity, HasAttachment;

    protected $table = 'pages';

    protected static $logAttributes = ['name', 'value'];

    protected static $logName = 'page';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Page has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'seo_meta_id',
    ];

    /**
     * Generate a url representing this resource.
     *
     * @return string
     */
    public final function getUrlAttribute()
    {
        return url($this->attributes['slug']);
    }

    /**
     * Checks to see if the current request is exactly for this page.
     *
     * @return bool
     */
    public final function getIsCurrentRouteAttribute()
    {
        return request()->is($this->attributes['slug']);
    }

    /**
     * Collects only active pages.
     *
     * @param Builder $query
     * @return Builder
     */
    public final function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public final function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }

    public final function sections()
    {
        return $this->belongsToMany(Section::class)->orderBy('order');
    }
}
