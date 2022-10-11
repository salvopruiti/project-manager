<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSession extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['started_at', 'stopped_at'];
    protected $appends = ['elapsed_time', 'elapsed_time_formatted'];

    public function elapsedTime() : Attribute
    {
        return new Attribute(
            fn() => ($this->stopped_at ?: now())->diffInRealSeconds($this->started_at)
        );
    }

    public function elapsedTimeFormatted() : Attribute
    {
        return new Attribute(
            fn() => gmdate('H:i:s', $this->elapsed_time)
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public static function start(Task $task)
    {
        $userId = auth()->id();

        if(($b = static::whereNull('stopped_at')->whereUserId($userId))->count()) {
            $b->update(['stopped_at' => now()]);
        }

        if(!$task->started_at) {
            $task->started_at = now();
            if(!$task->user_id) $task->user_id = auth()->id();
            $task->status = Status::IN_PROGRESS;

        }

        if($task->closed_at) {
            $task->closed_at = null;
            $task->status = Status::IN_PROGRESS;
        }

        $task->save();

        return $task->sessions()->create([
            'user_id' => $userId,
            'started_at' => now()
        ]);
    }

    public function stop()
    {
        $this->task()->update(['status' => Status::OPENED]);
        $this->update(['stopped_at' => now()]);
    }
}
