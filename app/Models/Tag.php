<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTag
 */
class Tag extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function taggables() { return $this->morphedByMany(Taggable::class, 'taggable'); }
}

