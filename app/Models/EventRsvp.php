<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEventRsvp
 */
class EventRsvp extends Model {
    use HasFactory;
    public function event() { return $this->belongsTo(GroupEvent::class); }
    public function user() { return $this->belongsTo(User::class); }
}
