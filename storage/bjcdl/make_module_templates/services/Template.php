<?php

namespace App\Services\DefaultServicePlural;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class DefaultService
 * @package App\Services\DefaultServicePlural
 * @author Richard Guevara
 */

class DefaultService extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'template_snake_case_plural';

    protected static $logAttributes = ['name'];

    protected static $logName = 'template_snake_case_plural';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "DefaultTemplate has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_active'
    ];
}
