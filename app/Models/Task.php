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
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory, HasAttachments;

    protected $dates = ['started_at', 'closed_at'];
    protected $guarded = [];

    public function code() : Attribute
    {
        return new Attribute(
            function() {
                return sprintf("%06d", $this->id);
            }
        );
    }

    public function isActive() : Attribute
    {
        return new Attribute(
            fn() => in_array($this->status, [Status::OPENED, Status::IN_PROGRESS])
        );
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket() : BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function sessions() : HasMany
    {
        return $this->hasMany(TaskSession::class);
    }

    public function activeSession() : HasOne
    {
        return $this->hasOne(TaskSession::class)->whereNull('stopped_at')->latestOfMany();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive($query)
    {
        $query->whereIn('status',[
           Status::OPENED,
           Status::IN_PROGRESS
        ]);
    }

    public function scopeWithSessionsTime($query)
    {
        $query->withAggregate('sessions as sessions_time', \DB::raw('SUM(TIMESTAMPDIFF(SECOND, started_at, ifnull(stopped_at,\''.now()->toDateTimeString().'\')))'));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(TagTask::class);
    }
}
