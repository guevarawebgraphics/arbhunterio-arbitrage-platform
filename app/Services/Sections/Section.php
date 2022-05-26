<?php

namespace App\Services\Sections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Traits\Attachments\HasAttachment;
use App\Services\Pages\Page;

/**
 * Class Section
 * @package App\Services\Sections
 * @author Bryan James Dela Luya
 */

class Section extends Model
{
    use SoftDeletes, LogsActivity, HasAttachment;

    const EDITOR = 1;
    const ATTACHMENT = 2;
    const FORM = 3;

    protected $table = 'sections';

    protected static $logAttributes = ['name', 'value'];

    protected static $logName = 'section';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Section has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'type'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['alias'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['pivot', 'deleted_at'];

    /**
     * Checks to see if this section is an editor.
     *
     * @return bool
     */
    public final function getIsEditorAttribute()
    {
        return $this->attributes['type'] === self::EDITOR;
    }

    /**
     * Checks to see if this section is an attachment.
     *
     * @return bool
     */
    public final function getIsAttachmentAttribute()
    {
        return $this->attributes['type'] === self::ATTACHMENT;
    }

    /**
     * Checks to see if this section is a form.
     *
     * @return bool
     */
    public final function getIsFormAttribute()
    {
        return $this->attributes['type'] === self::FORM;
    }

    /**
     * Generate a slug base on the section name.
     *
     * @return string
     */
    public final function getAliasAttribute()
    {
        return str_slug($this->attributes['name']);
    }

    /**
     * Get and parse the section content.
     *
     * @param Builder $query
     * @param string $name
     * @return false|mixed|string
     */
    public final function scopeContent(Builder $query,$name)
    {
        $section = $query->whereName($name)->first();

        if (empty($section)) return '';

        if ($section->isAttachment)
            return $section->attachment;

        if ($section->isEditor)
            return parse($section->value);

        if ($section->isForm)
            return json_decode($section->value);

        return '';
    }

    public final function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}
