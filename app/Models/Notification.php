<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNotification
 */
class Notification extends Model {
    use HasFactory;
    protected $fillable = [
        'type',
        'notifiable_id',
        'notifiable_type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function markAsRead(): bool
    {
        $this->read_at = now();
        return $this->save();
    }
}
