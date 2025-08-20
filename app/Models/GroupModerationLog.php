<?php

namespace App\Models;

use App\Models\Builders\GroupModerationLogQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperGroupModerationLog
 */
class GroupModerationLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'group_id',
        'moderator_id',
        'action',
        'targetable_id',
        'targetable_type',
        'description',
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
}
