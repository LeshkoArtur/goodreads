<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTaggable
 */
class Taggable extends Model {
    use HasFactory;
    protected $primaryKey = ['tag_id', 'taggable_id', 'taggable_type'];

    protected $keyType = 'string';
    public function tag() { return $this->belongsTo(Tag::class); }
    public function taggable() { return $this->morphTo(); }
}
