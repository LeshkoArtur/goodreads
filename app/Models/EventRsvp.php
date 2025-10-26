<?php

namespace App\Models;

use App\Enums\EventResponse;
use App\Models\Builders\EventRsvpQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperEventRsvp
 */
class EventRsvp extends Model
{
    use HasFactory, HasUuids, Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_event_id' => $this->group_event_id,
            'user_id' => $this->user_id,
            'response' => $this->response,
        ];
    }

    public function searchableAs(): string
    {
        return 'event_rsvps';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_event_id',
                'user_id',
                'response',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
