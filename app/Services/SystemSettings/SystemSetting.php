<?php

namespace App\Services\SystemSettings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SystemSetting
 * @package App\Services\SystemSettings
 * @author Richard Guevara
 */

class SystemSetting extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'system_settings';

    protected static $logAttributes = ['name', 'value'];

    protected static $logName = 'system_setting';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "System Setting has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
    ];
}
