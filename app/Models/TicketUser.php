<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\TicketUser
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $user_id
 * @property int $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereUserId($value)
 * @mixin \Eloquent
 */
class TicketUser extends Pivot
{
    //
}
