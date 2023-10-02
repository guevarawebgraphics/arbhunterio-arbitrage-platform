<?php

namespace App\Services\MenuDropdowns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\Menus\Menu;
use App\Services\Pages\Page;

/**
 * Class Contact
 * @package App\Services\MenuDropdowns
 * @author Guevara Web Graphics Studio
 */

class MenuDropdown extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'menu_dropdown';

    protected static $logAttributes = ['name', 'email', 'subject', 'message'];

    protected static $logName = 'menu_dropdown';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Menu Dropdown has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'name',
        'is_page',
        'page_id',
        'link',
        'open_in_new_tab',
        'order_number',
        'is_active',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
