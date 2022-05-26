<?php

namespace App\Services\CategoryPerProducts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ProductCategories\ProductCategory;

/**
 * Class Product
 * @package App\Services\CategoryPerProducts
 * @author Richard Guevara
 */

class CategoryPerProduct extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
