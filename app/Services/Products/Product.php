<?php

namespace App\Services\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Traits\Attachments\HasAttachment;
use App\Services\SeoMetas\SeoMeta;
use App\Services\CategoryPerProducts\CategoryPerProduct;

/**
 * Class Product
 * @package App\Services\Products
 * @author Guevara Web Graphics Studio
 */

class Product extends Model
{
    use SoftDeletes, LogsActivity, HasAttachment;

    const GALLERY = 'product_gallery';

    protected $table = 'products';

    protected static $logAttributes = ['title', 'content'];

    protected static $logName = 'products';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Product has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'sku',
        'slug',
        'content',
        'image',
        'seo_meta_id',
        'is_active'
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

    public function gallery()
    {
        return $this->attachmentFor(self::GALLERY);
    }

    public final function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }

    public function perCategory()
    {
        return $this->belongsTo(CategoryPerProduct::class, 'id');
    }
}
