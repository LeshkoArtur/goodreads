<?php

namespace App\Models;

use App\Models\Builders\PollOptionQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperPollOption
 */
class PollOption extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_poll_id',
        'text',
        'vote_count',
    ];

    public function newEloquentBuilder($query): PollOptionQueryBuilder
    {
        return new PollOptionQueryBuilder($query);
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(GroupPoll::class, 'group_poll_id');
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_poll_id' => $this->group_poll_id,
            'text' => $this->text,
            'vote_count' => $this->vote_count,
        ];
    }

    public function searchableAs(): string
    {
        return 'poll_options';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_poll_id',
                'vote_count',
            ],
            'sortableAttributes' => ['created_at', 'vote_count'],
        ];
    }
}
