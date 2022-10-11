<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasAttachments;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory, HasAttachments;

    protected $guarded = [];

    public function code() : Attribute
    {
        return new Attribute(
            function() {
                return sprintf("%06d", $this->id);
            }
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['is_primary'])->using(TicketUser::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function activeTasks() : HasMany
    {
        return $this->tasks()->whereIn('status', [Status::OPENED, Status::IN_PROGRESS]);
    }

    public function notes() : HasMany
    {
        return $this->hasMany(TicketNote::class);
    }

    public function checkForTaskCompletation()
    {
        if($this->tasks()->count() && !$this->activeTasks()->count()) {
            $this->update(['status' => Status::RESOLVED]);
        }
    }
}
