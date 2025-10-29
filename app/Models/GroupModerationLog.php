<?php

namespace App\Models;

use App\Enums\ModerationAction;
use App\Models\Builders\GroupModerationLogQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperGroupModerationLog
 */
class GroupModerationLog extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_id',
        'moderator_id',
        'action',
        'targetable_id',
        'targetable_type',
        'description',
    ];

    protected $casts = [
        'group_id' => 'string',
        'moderator_id' => 'string',
        'action' => ModerationAction::class,
        'targetable_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): GroupModerationLogQueryBuilder
    {
        return new GroupModerationLogQueryBuilder($query);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function targetable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'moderator_id' => $this->moderator_id,
            'action' => $this->action,
            'targetable_id' => $this->targetable_id,
            'targetable_type' => $this->targetable_type,
            'description' => $this->description,
        ];
    }

    public function searchableAs(): string
    {
        return 'group_moderation_logs';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_id',
                'moderator_id',
                'action',
                'targetable_type',
                'targetable_id',
            ],
            'sortableAttributes' => ['created_at', 'action'],
        ];
    }
}
