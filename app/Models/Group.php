<?php

namespace App\Models;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Builders\GroupQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'creator_id',
        'is_public',
        'cover_image',
        'rules',
        'member_count',
        'is_active',
        'join_policy',
        'post_policy',
    ];

    protected $casts = [
        'creator_id' => 'string',
        'is_public' => 'boolean',
        'member_count' => 'integer',
        'is_active' => 'boolean',
        'join_policy' => JoinPolicy::class,
        'post_policy' => PostPolicy::class,
    ];

    public function newEloquentBuilder($query): GroupQueryBuilder
    {
        return new GroupQueryBuilder($query);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('role', 'status', 'joined_at');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(GroupPost::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(GroupEvent::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(GroupInvitation::class);
    }

    public function polls(): HasMany
    {
        return $this->hasMany(GroupPoll::class);
    }

    public function moderationLogs(): HasMany
    {
        return $this->hasMany(GroupModerationLog::class);
    }
}
