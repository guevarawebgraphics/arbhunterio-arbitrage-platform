<?php

namespace App\Http\Traits\Attachments;

use App\Services\Attachments\Attachment;

/**
 * trait HasAttachments
 * @package App\Http\Traits\Attachment
 * @author Bryan James Dela Luya
 */

trait HasAttachments
{
    use HandlesAttachments;

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable', 'attachables');
    }
} 
