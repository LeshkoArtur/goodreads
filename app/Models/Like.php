<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLike
 */
class Like extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'likeable_id',
        'likeable_type',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function likeable() { return $this->morphTo(); }
}
