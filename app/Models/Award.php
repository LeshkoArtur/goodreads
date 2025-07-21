<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAward
 */
class Award extends Model {
    use HasFactory;
    public function nominations() { return $this->hasMany(Nomination::class); }
}
