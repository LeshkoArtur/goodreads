<?php

namespace App\Models;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\Builders\GroupPostQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperGroupPost
 */
class GroupPost extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'group_id',
        'user_id',
        'content',
        'is_pinned',
        'category',
        'post_status',
    ];

    protected $casts = [
        'group_id' => 'string',
        'user_id' => 'string',
        'is_pinned' => 'boolean',
        'category' => PostCategory::class,
        'post_status' => PostStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): GroupPostQueryBuilder
    {
        return new GroupPostQueryBuilder($query);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function moderationLogs(): MorphMany
    {
        return $this->morphMany(GroupModerationLog::class, 'targetable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'is_pinned' => $this->is_pinned,
            'category' => $this->category,
            'post_status' => $this->post_status,
        ];
    }

    public function searchableAs(): string
    {
        return 'group_posts';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'group_id',
                'user_id',
                'is_pinned',
                'category',
                'post_status',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
