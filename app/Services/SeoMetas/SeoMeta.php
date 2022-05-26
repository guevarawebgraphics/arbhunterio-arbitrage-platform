<?php

namespace App\Services\SeoMetas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Sections\Section;

/**
 * Class SeoMeta
 * @package App\Services\SeoMetas
 * @author Bryan James Dela Luya
 */

class SeoMeta extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'seo_metas';

    protected static $logAttributes = ['metal_title', 'meta_keywords', 'meta_description'];

    protected static $logName = 'seo_meta';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "SEO Meta has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_title',
        'meta_keywords',
        'meta_description',
        'canonical_link',
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
