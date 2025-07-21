<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReadingStat
 */
class ReadingStat extends Model {
    use HasFactory;
    public function user() { return $this->belongsTo(User::class); }
}
