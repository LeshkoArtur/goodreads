<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupInvitation
 */
class GroupInvitation extends Model {
    use HasFactory;
    public function group() { return $this->belongsTo(Group::class); }
    public function inviter() { return $this->belongsTo(User::class, 'inviter_id'); }
    public function invitee() { return $this->belongsTo(User::class, 'invitee_id'); }
}
