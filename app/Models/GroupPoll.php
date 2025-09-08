<?php

namespace App\Models;

use App\Models\Builders\GroupPollQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperGroupPoll
 */
class GroupPoll extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_id',
        'creator_id',
        'question',
        'is_active',
    ];

    protected $casts = [
        'group_id' => 'string',
        'creator_id' => 'string',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): GroupPollQueryBuilder
    {
        return new GroupPollQueryBuilder($query);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'creator_id' => $this->creator_id,
            'question' => $this->question,
            'is_active' => $this->is_active,
        ];
    }

    public function searchableAs(): string
    {
        return 'group_polls';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_id',
                'creator_id',
                'is_active',
            ],
            'sortableAttributes' => ['question', 'created_at'],
        ];
    }
}
