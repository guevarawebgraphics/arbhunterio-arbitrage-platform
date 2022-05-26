<?php

namespace App\Services\Menus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Pages\Page;

/**
 * Class Contact
 * @package App\Services\Menus
 * @author Richard Guevara
 */

class Menu extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'menu';

    protected static $logAttributes = ['name', 'email', 'subject', 'message'];

    protected static $logName = 'menu';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Menu has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_page',
        'page_id',
        'link',
        'open_in_new_tab',
        'order_number',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
