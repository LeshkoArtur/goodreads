<?php

namespace App\Models;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
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
        'id' => 'string',
        'creator_id' => 'string',
        'is_public' => 'boolean',
        'member_count' => 'integer',
        'is_active' => 'boolean',
        'join_policy' => JoinPolicy::class,
        'post_policy' => PostPolicy::class,
    ];
    public function creator() { return $this->belongsTo(User::class, 'creator_id'); }
    public function members() { return $this->belongsToMany(User::class, 'group_members')->withPivot('role', 'status', 'joined_at'); }
    public function posts() { return $this->hasMany(GroupPost::class); }
    public function events() { return $this->hasMany(GroupEvent::class); }
    public function invitations() { return $this->hasMany(GroupInvitation::class); }
    public function polls() { return $this->hasMany(GroupPoll::class); }
    public function moderationLogs() { return $this->hasMany(GroupModerationLog::class); }
}
