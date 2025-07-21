<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLike
 */
class Like extends Model {
    use HasFactory;
    public function user() { return $this->belongsTo(User::class); }
    public function likeable() { return $this->morphTo(); }
}
