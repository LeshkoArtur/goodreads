<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPollOption
 */
class PollOption extends Model {
    use HasFactory;
    protected $fillable = [
        'group_poll_id',
        'text',
        'vote_count',
    ];
    public function poll() { return $this->belongsTo(GroupPoll::class); }
}
