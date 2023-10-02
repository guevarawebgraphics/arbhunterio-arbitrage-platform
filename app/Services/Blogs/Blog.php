<?php

namespace App\Services\Blogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\BlogCategories\BlogCategory;
use App\Services\SeoMetas\SeoMeta;

/**
 * Class Blog
 * @package App\Services\Blogs
 * @author Guevara Web Graphics Studio
 */

class Blog extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'blogs';

    protected static $logAttributes = ['name', 'description'];

    protected static $logName = 'blogs';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Blog has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_category_id',
        'title',
        'author',
        'content',
        'thumbnail',
        'cover_image',
        'seo_meta_id',
        'is_active',
        'is_featured'
    ];

    protected $with = [
        'category',
    ];

    public function setTitleAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {

            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug) {

        $original = $slug;
    
        $count = 2;
    
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public final function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }
}
