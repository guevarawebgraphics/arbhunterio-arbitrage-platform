<?php

namespace App\Http\Traits\Attachments;

use App\Services\Attachments\Attachment;

/**
 * trait HasAttachments
 * @package App\Http\Traits\Attachment
 * @author Guevara Web Graphics Studio
 */

trait HasAttachments
{
    use HandlesAttachments;

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable', 'attachables');
    }
} 
