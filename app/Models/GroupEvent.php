<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupEvent
 */
class GroupEvent extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'group_id',
        'creator_id',
        'title',
        'description',
        'event_date',
        'location',
        'group_status',
    ];

    protected $casts = [
        'id' => 'string',
        'group_id' => 'string',
        'creator_id' => 'string',
        'event_date' => 'datetime',
        'group_status' => EventStatus::class,
    ];
    public function group() { return $this->belongsTo(Group::class); }
    public function creator() { return $this->belongsTo(User::class, 'creator_id'); }
    public function rsvps() { return $this->hasMany(EventRsvp::class); }
}
