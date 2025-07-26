<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupInvitation
 */
class GroupInvitation extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'group_id',
        'inviter_id',
        'invitee_id',
        'invitation_status',
    ];
    public function group() { return $this->belongsTo(Group::class); }
    public function inviter() { return $this->belongsTo(User::class, 'inviter_id'); }
    public function invitee() { return $this->belongsTo(User::class, 'invitee_id'); }
}
