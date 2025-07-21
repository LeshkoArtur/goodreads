<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupModerationLog
 */
class GroupModerationLog extends Model {
    use HasFactory;
    public function group() { return $this->belongsTo(Group::class); }
    public function moderator() { return $this->belongsTo(User::class, 'moderator_id'); }
}
