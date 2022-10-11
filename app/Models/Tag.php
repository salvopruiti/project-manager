<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $guarded = [];

    public function tasks() : BelongsToMany
    {
        return $this->belongsToMany(Task::class)->using(TagTask::class);
    }
}
