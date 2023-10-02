<?php

namespace App\Services\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Attachment
 * @package App\Services\Attachments
 * @author Guevara Web Graphics Studio
 */

class Attachment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'attachments';

    protected static $logAttributes = ['name', 'value'];

    protected static $logName = 'attachment';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Attachment has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mime',
        'alias',
        'folder',
        'extension',
        'identifier'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Generate a url that represents this resource.
     *
     * @return string
     */
    public final function getUrlAttribute() : string
    {
        $path = $this->attributes['folder'] . '/' . $this->attributes['alias'];

        return url("public/storage/$path");
    }

    /**
     * Return the url when serialized.
     *
     * @return string
     */
    public final function __toString() : string
    {
        return $this->getUrlAttribute();
    }
}
