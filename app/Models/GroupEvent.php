<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Models\Builders\GroupEventQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperGroupEvent
 */
class GroupEvent extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_id',
        'creator_id',
        'title',
        'description',
        'event_date',
        'location',
        'status',
    ];

    protected $casts = [
        'group_id' => 'string',
        'creator_id' => 'string',
        'event_date' => 'datetime',
        'status' => EventStatus::class,
    ];

    public function newEloquentBuilder($query): GroupEventQueryBuilder
    {
        return new GroupEventQueryBuilder($query);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'creator_id' => $this->creator_id,
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'location' => $this->location,
            'status' => $this->status,
        ];
    }

    public function searchableAs(): string
    {
        return 'group_events';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_id',
                'creator_id',
                'status',
                'event_date',
                'location',
            ],
            'sortableAttributes' => ['title', 'event_date', 'created_at'],
        ];
    }
}
