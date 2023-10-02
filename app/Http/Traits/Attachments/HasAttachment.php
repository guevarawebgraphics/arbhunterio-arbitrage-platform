<?php

namespace App\Http\Traits\Attachments;

use App\Services\Attachments\Attachment;

/**
 * trait HandlesAttachments
 * @package App\Http\Traits\Attachment
 * @author Guevara Web Graphics Studio
 */

trait HasAttachment
{
    use HandlesAttachments;

    /**
     * Get the file attached to the resource.
     *
     * @return Attachment|null
     */
    public function getAttachmentAttribute()
    {
        return $this->attachment()->first();
    }

    public function attachment()
    {
        return $this->attachmentFor();
    }

    private function attachmentFor($identfier = 'default')
    {
        return $this->morphToMany(Attachment::class, 'attachable', 'attachables')->where('identifier', $identfier);
    }
} 
