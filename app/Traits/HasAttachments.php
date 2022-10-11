<?php

namespace App\Traits;

use App\Models\Attachment;

trait HasAttachments
{
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'owner');
    }
}
