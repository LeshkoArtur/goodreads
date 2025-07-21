<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupEvent
 */
class GroupEvent extends Model {
    use HasFactory;
    public function group() { return $this->belongsTo(Group::class); }
    public function creator() { return $this->belongsTo(User::class, 'creator_id'); }
    public function rsvps() { return $this->hasMany(EventRsvp::class); }
}
