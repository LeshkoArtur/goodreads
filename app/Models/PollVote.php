<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPollVote
 */
class PollVote extends Model {
    use HasFactory;
    public function poll() { return $this->belongsTo(GroupPoll::class); }
    public function option() { return $this->belongsTo(PollOption::class); }
    public function user() { return $this->belongsTo(User::class); }
}
