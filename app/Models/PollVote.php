<?php

namespace App\Models;

use App\Models\Builders\PollVoteQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperPollVote
 */
class PollVote extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_poll_id',
        'poll_option_id',
        'user_id',
        'created_at',
    ];

    public function newEloquentBuilder($query): PollVoteQueryBuilder
    {
        return new PollVoteQueryBuilder($query);
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(GroupPoll::class, 'group_poll_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(PollOption::class, 'poll_option_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_poll_id' => $this->group_poll_id,
            'poll_option_id' => $this->poll_option_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }

    public function searchableAs(): string
    {
        return 'poll_votes';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_poll_id',
                'poll_option_id',
                'user_id',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
