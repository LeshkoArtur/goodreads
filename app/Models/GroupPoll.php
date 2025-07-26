<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupPoll
 */
class GroupPoll extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'group_id',
        'creator_id',
        'question',
        'is_active',
    ];
    public function group() { return $this->belongsTo(Group::class); }
    public function creator() { return $this->belongsTo(User::class, 'creator_id'); }
    public function options() { return $this->hasMany(PollOption::class); }
    public function votes() { return $this->hasMany(PollVote::class); }
}
