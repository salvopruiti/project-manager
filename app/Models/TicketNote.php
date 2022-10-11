<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TicketNote
 *
 * @property int $id
 * @property int $ticket_id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketNote whereUserId($value)
 * @mixin \Eloquent
 */
class TicketNote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
