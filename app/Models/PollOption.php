<?php

namespace App\Models;

use App\Models\Builders\PollOptionQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperPollOption
 */
class PollOption extends Model
{
    use HasFactory, HasUuids;

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
}
