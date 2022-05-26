<?php

namespace App\Http\Traits\Attachments;

use App\Services\Attachments\Attachment;
use Illuminate\Http\UploadedFile;

/**
 * trait HandlesAttachments
 * @package App\Http\Traits\Attachment
 * @author Richard Guevara
 */

trait HandlesAttachments
{
    public function attach($files, $identifier = 'default')
    {
        if ($files instanceof UploadedFile)
            $this->handleUpload($files, $identifier);
        if (is_array($files) || $files instanceof \Traversable)
            foreach ($files as $file)
                $this->handleUpload($file, $identifier);
    }

    private function handleUpload(UploadedFile $file, $identifier)
    {
        $namespace = explode('\\', get_class($this));
        $class = end($namespace);
        $alias = str_random() . '.' . $file->getClientOriginalExtension();

        $attachment = new Attachment();
        $attachment->alias = $alias;
        $attachment->folder = $class;
        $attachment->mime = $file->getClientMimeType();
        $attachment->name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $file->getClientOriginalExtension();;
        $attachment->extension = $file->getClientOriginalExtension();
        $attachment->identifier = $identifier;

        if ($identifier === 'default') {
            if (method_exists($this, 'attachment')) {
                $this->attachment()->count() > 0 && $this->attachment()->delete();

                $this->attachment()->save($attachment);
            } else if (method_exists($this, 'attachments')) {
                $this->attachments()->save($attachment);
            } else return null;
            
        } elseif($identifier == 'product_gallery') {

            $this->attachmentFor($identifier)->save($attachment);
        } else {
            if (method_exists($this, $identifier)) {
                $this->$identifier()->count() > 0 && $identifier->$identifier()->delete();

                $this->$identifier()->save($attachment);
            }
        }

        $file->move(public_path('storage/' . $class), $attachment->alias);

        return $attachment;
    }
} 
