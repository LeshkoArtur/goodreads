<?php

namespace App\Models;

use App\Enums\EventResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEventRsvp
 */
class EventRsvp extends Model {
    use HasFactory;
    protected $primaryKey = ['event_id', 'user_id'];

    protected $casts = [
        'event_id' => 'string',
        'user_id' => 'string',
        'event_response' => EventResponse::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'event_id',
        'user_id',
        'event_response',
    ];
    public function event() { return $this->belongsTo(GroupEvent::class); }
    public function user() { return $this->belongsTo(User::class); }
}
