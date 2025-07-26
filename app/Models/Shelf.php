<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperShelf
 */
class Shelf extends Model {
    use HasFactory;
    protected $casts = [
        'user_id' => 'string',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function userBooks() { return $this->hasMany(UserBook::class); }
}
