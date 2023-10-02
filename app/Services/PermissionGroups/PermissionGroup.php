<?php

namespace App\Services\PermissionGroups;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class PermissionGroup
 * @package App\Services\PermissionGroups
 * @author Guevara Web Graphics Studio
 */

class PermissionGroup extends Model
{
    use SoftDeletes,LogsActivity;

    protected $table = 'permission_groups';

    protected static $logAttributes = ['name'];

    protected static $logName = 'permission_group';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Permission Group has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function permissions() {
        return $this->hasMany('Spatie\Permission\Models\Permission', 'permission_group_id');

    }
}
