<?php

namespace App\Models;

use App\Models\Builders\CommentQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphMany, MorphTo};
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperComment
 */
class Comment extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'content',
        'parent_id',
    ];

    protected $casts = [
        'user_id' => 'string',
        'parent_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): CommentQueryBuilder
    {
        return new CommentQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function moderationLogs(): MorphMany
    {
        return $this->morphMany(GroupModerationLog::class, 'targetable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'content' => $this->content,
            'parent_id' => $this->parent_id,
        ];
    }

    public function searchableAs(): string
    {
        return 'comments';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'commentable_type',
                'commentable_id',
                'parent_id',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
