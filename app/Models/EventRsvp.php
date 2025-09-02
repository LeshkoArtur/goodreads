<?php

namespace App\Models;

use App\Enums\EventResponse;
use App\Models\Builders\EventRsvpQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperEventRsvp
 */
class EventRsvp extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'group_event_id',
        'user_id',
        'response',
    ];

    protected $casts = [
        'group_event_id' => 'string',
        'user_id' => 'string',
        'response' => EventResponse::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): EventRsvpQueryBuilder
    {
        return new EventRsvpQueryBuilder($query);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
