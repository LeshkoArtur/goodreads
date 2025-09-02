<?php

namespace App\Models;

use App\Models\Builders\GroupPollQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperGroupPoll
 */
class GroupPoll extends Model
{
    use HasFactory, HasUuids;

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
}
