<?php

namespace App\Models;

use App\Enums\InvitationStatus;
use App\Models\Builders\GroupInvitationQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperGroupInvitation
 */
class GroupInvitation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'group_id',
        'inviter_id',
        'invitee_id',
        'status',
    ];

    protected $casts = [
        'group_id' => 'string',
        'inviter_id' => 'string',
        'invitee_id' => 'string',
        'status' => InvitationStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): GroupInvitationQueryBuilder
    {
        return new GroupInvitationQueryBuilder($query);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function invitee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }
}
