<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCharacter
 */
class Character extends Model {
    use HasFactory;
    public function book() { return $this->belongsTo(Book::class); }
}
