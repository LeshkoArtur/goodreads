<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupModerationLog
 */
class GroupModerationLog extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'group_id',
        'moderator_id',
        'action',
        'targetable_id',
        'targetable_type',
        'description',
    ];
    public function group() { return $this->belongsTo(Group::class); }
    public function moderator() { return $this->belongsTo(User::class, 'moderator_id'); }
}
