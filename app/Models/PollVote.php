<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPollVote
 */
class PollVote extends Model {
    use HasFactory;
    protected $primaryKey = ['group_poll_id', 'user_id'];

    protected $fillable = [
        'group_poll_id',
        'poll_option_id',
        'user_id',
        'created_at',
    ];

    public function poll() { return $this->belongsTo(GroupPoll::class); }
    public function option() { return $this->belongsTo(PollOption::class); }
    public function user() { return $this->belongsTo(User::class); }
}
